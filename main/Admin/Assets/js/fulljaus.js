/* ------------------------------------------------------------------------------
 *
 *  # Fulljaus
 *
 *  Incluye los controles para que funcione la applicación
 *
 * ---------------------------------------------------------------------------- */

var Fulljaus = {
    popupForm: function () {
        return false;
    },


    templateSelectPersons: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.name}, ${record.dni}
                    </div>
                    <div class='select2-result-repository__description'>
                        ${record.city.name}, ${record.city.region.name}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectProducts: function (record) {
        const avatar_div = record.icon ? `<div class='select2-result-repository__avatar'><img src='${record.icon}' /></div>` : ``;
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                ${ avatar_div}
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                    <div class='row'>     
                        <div class='col-lg-10 col-md-8 col-12'>
                                ${record.sku}, ${record.name}
                            </div>
                            <div class='col-lg-2 col-md-4 col-12'>
                                $ ${record.unitPrice} (${record.currency})
                            </div>
                        </div>
                    </div>
                    <div class='select2-result-repository__description'>
                        ${record.description}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectEmployees: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.text}
                    </div>
                    <div class='select2-result-repository__description'>
                        DNI: ${record.element.dataset.dni}
                    </div>
                    <div class='select2-result-repository__description'>
                        Legajo: ${record.element.dataset.docket}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectUsers: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.text}
                    </div>
                    <div class='select2-result-repository__description'>
                        DNI: ${record.element.dataset.dni}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectSalaryItems: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.text}
                    </div>
                    <div class='select2-result-repository__description'>
                        ${record.element.dataset.description}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectDepartments: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.text}
                    </div>
                    <div class='select2-result-repository__description'>
                        ${record.element.dataset.parent_name}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectCategories: function (record) {
        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        ${record.text}
                    </div>
                    <div class='select2-result-repository__description'>
                        ${record.element.dataset.parent_name}
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateSelectIdField: function (record) {

        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                        (${record.element.dataset.id}) ${record.element.dataset.field} 
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    templateLanguageCode: function (record) {

        var $container = $(
            `<div class='select2-result-repository clearfix'>
                <div class='select2-result-repository__meta'>
                    <div class='select2-result-repository__title'>
                         ${record.element.dataset.code} 
                    </div>
                </div>
            </div>`
        );

        return $container;
    },

    searchingTimeout: null,
    searchData: function () {
        idpage = 1;

        clearTimeout(this.searchingTimeout);

        this.searchingTimeout = setTimeout(function () {
            Fulljaus.refreshData();
        }, 600);
    },

    
    refreshData: function (pag) {
        var totalpages = 1;
        var currentpage = 1;
        var noData=$("#table-list-2").attr("noData");

        $.ajax({
            type: "POST",
            url: route_getdata,
            data: {
                _token: _token,
                filter_search: $("#filtersearch").val(),
                filter_id: $("#filterlist").val(),
                page: idpage,
                ordinal_field: ordinal_field,
                ordinal_order: ordinal_order,
            },
            success: function (response) {
                // console.log(response);
                if (typeof response.status != "undefined") {
                    if (response.status == "true") {
                        if (typeof response.data.data != "undefined") {
                            bigdata = response.data.data;
                            if (
                                typeof response.data.current_page != "undefined"
                            ) {
                                totalpages = response.data.last_page;
                                currentpage = response.data.current_page;
                            }
                        } else if (typeof response.data != "undefined") {
                            bigdata = response.data;
                        } else {
                            bigdata = "";
                        }

                        if (bigdata == "") {
                            html =
                                '<tr><td colspan="6"><h4 class="text-center mt-4 mb-4">'+noData+'</h4></td></tr>';
                        } else {
                            html = Fulljaus.tableHtml(bigdata);
                        }

                        $("#sortable-data")
                            .html(html)
                            .promise()
                            .done(function () {
                                html2 = Fulljaus.paginateHtml(
                                    totalpages,
                                    currentpage
                                );
                                $(".paginate_table")
                                    .html(html2)
                                    .promise()
                                    .done(function () {
                                        Fulljaus.eventsHtml();
                                    });

                                var htmlFooter = Fulljaus.paginateFooterHtml(
                                    totalpages,
                                    currentpage
                                );
                                $(".paginate_table_footer").html(htmlFooter);
                            });

                        //Fulljaus.eventsHtml();
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert("Server not respond, please refresh your page");
                }
            },
            error: function (data, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
            },
        });
    },
    tableHtml: function (bigdata) {
        var html = "";
        var textActive = $("#table-list").attr("data-active");
        var textInactive = $("#table-list").attr("data-inactive");
        var textApproved = $("#table-list").attr("data-approved");
        var textDisapproved = $("#table-list").attr("data-disapproved");

        $.each(bigdata, function (k, record) {
            html += `<tr role="row" id="row-${record.id}">`;
            var i = 0;

            if (sort_field === "true") {
                html += '<td class="dragndrop"></td>';
                i++;
            }

            $.each(listfields, function (i, fieldname) {
                switch (fieldname) {
                    case "icon" :
                        
                        html += record[fieldname] ? `<td><img class="img-thumbnail" src="`+record[fieldname]+`" ></td>` : `<td></td>`;
                        break;
                    case "status":
                        if (record[fieldname] === 1) {
                            html +=
                            `<td><span class="badge bg-purple">`+textActive+`</span></td>`;
                        } else {
                            html +=
                            `<td><span class="badge badge-danger">`+textInactive+`</span></td>`;
                        }
                        break;
                    case "approved":
                        if (record[fieldname] === 1) {
                            html +=
                            `<td><span class="badge bg-success">Aprobado</span></td>`;
                        } else {
                            html +=
                            `<td><span class="badge badge-warning">Pendiente</span></td>`;
                        }
                        break;
                    case "status2":
                        var content_td = `<select id="status${record.id}" class="form-control row-select2" data-fouc>`;

                        if (record[fieldname] === 1) {
                            content_td +=
                                `<option value="1" selected>`+textActive+`</option>`;
                            content_td += `<option value="0">`+textInactive+`</option>`;
                        } else {
                            content_td += `<option value="1">`+textActive+`</option>`;
                            content_td +=
                                `<option value="0" selected>`+textInactive+`</option>`;
                        }
                        content_td += "</select>";
                        html += `<td>${content_td}</td>`;

                        break;
                    case "created_at":
                        var d = new Date(record[fieldname]);
                        html += `<td>${d.toLocaleString()}</td>`;
                        break;
                    case "web":
                        html += '<td><span class="badge bg-'+((record[fieldname] == '1')?'success':'warning')+'">'+((record[fieldname] == '1')?'Sí':'No')+'</span></td>';
                        break;
                    default:
                        html += "<td>";
                        var content_td = "";
                        var start_united = [
                            '<div class="font-weight-semibold">',
                            '<div class="text-muted">',
                        ];
                        var end_united = "</div>";

                        var fieldsUnited = fieldname.split("+");
                        if (fieldsUnited.length > 1) {
                            $.each(fieldsUnited, function (k, unitedname) {
                                var fieldsRelation = unitedname.split("->");
                                content_td += start_united[k];
                                //var fieldsRelation = unitedname.split('->');
                                switch (fieldsRelation.length) {
                                    case 1:
                                        try {
                                            content_td +=
                                                record[unitedname] ?? "&nbsp;";
                                        } catch {}
                                        break;
                                    case 2:
                                        try {
                                            content_td +=
                                                record[fieldsRelation[0]][
                                                    fieldsRelation[1]
                                                ];
                                        } catch {}
                                        break;
                                    case 3:
                                        try {
                                            content_td +=
                                                record[fieldsRelation[0]][
                                                    fieldsRelation[1]
                                                ][fieldsRelation[2]];
                                        } catch {}
                                        break;
                                    case 4:
                                        try {
                                            content_td +=
                                                record[fieldsRelation[0]][
                                                    fieldsRelation[1]
                                                ][fieldsRelation[2]][
                                                    fieldsRelation[3]
                                                ];
                                        } catch {}
                                        break;
                                }
                                content_td += end_united;
                            });
                        } else {
                            var fieldsRelation = fieldname.split("->");
                            switch (fieldsRelation.length) {
                                case 1:
                                    try {
                                        content_td = record[fieldname];
                                    } catch {}
                                    break;
                                case 2:
                                    try {
                                        content_td =
                                            record[fieldsRelation[0]][
                                                fieldsRelation[1]
                                            ];
                                    } catch {}
                                    break;
                                case 3:
                                    try {
                                        content_td =
                                            record[fieldsRelation[0]][
                                                fieldsRelation[1]
                                            ][fieldsRelation[2]];
                                    } catch {}
                                    break;
                                case 4:
                                    try {
                                        content_td =
                                            record[fieldsRelation[0]][
                                                fieldsRelation[1]
                                            ][fieldsRelation[2]][
                                                fieldsRelation[3]
                                            ];
                                    } catch {}
                                    break;
                            }
                        }

                        html += content_td == null ? "" : content_td;
                        html += "</td>";
                        break;
                }
            });
            html += Fulljaus.actionTableHtml(record);
            html += "</tr>";
        });
        return html;
    },
    actionTableHtml: function (record) {
        action_html = "";

        $.each(model_info["actions"], function (n, action) {
            if (action["type"] == "link") {
                action_html += `<a href="${action["route"] + record.id}" class="btn p-1 m-1 ${action["icon_class"]}">
                                    <i class="${action["icon"]} text-white"></i>
                                </a>`;
            }
            if (action["type"] == "link-custom") {
                action_html += `<a href="${action["route"].replace('replace_me', record.id)}" class="btn p-1 m-1 ${action["icon_class"]}">
                                    <i class="${action["icon"]} text-white"></i>
                                </a>`;
            }
            if (action["type"] == "print") {
                action_html += `<a href="${action["route"] + record.id}" target="_blank" class="btn p-1 m-1 ${action["icon_class"]}">
                                    <i class="${action["icon"]} text-white"></i>
                                </a>`;
            }
            if (action["type"] == "button") {
                aevent = action["event"] ?? "";
                action_html += `<form action="${action["route"]}" method="POST" ${aevent} style="display: inline">
                                    <input type="hidden" name="_token" value="${_token}">
                                    <input type="hidden" name="id" value="${record.id}">
                                    <button title="${action["title"]}" type="submit" class="btn p-1 m-1 ${action["icon_class"]}">
                                        <i class="${action["icon"]} text-white"></i>
                                    </button>
                                </form>`;
            }
            if (action["type"] == "patch-form-button") {
                aevent = action["event"] ?? "";
                action_html += `<form action="${action["route"].replace('replace_me', record.id)}" method="POST" class="d-inline" ${aevent}>
                                    <input type="hidden" name="_token" value="${_token}">
                                    <input type="hidden" name="_method" value="PATCH">
                                    <button title="${action["title"]}" type="submit" class="btn p-1 m-1 ${action["icon_class"]}">
                                        <i class="${action["icon"]} text-white"></i>
                                    </button>
                                </form>`;
            }
            if (action["type"] == "script") {
                action_html += `<button onclick="${action["action"]}(${record.id})" class="btn p-1 m-1 ${action["icon_class"]}">
                                    <i class="${action["icon"]} text-white"></i>
                                </button>`;
            }
        });
        return `<td>${action_html}</td>`;
    },
    paginateFooterHtml: function (totalpages, currentpage) {
        var paginador =
            '<ul class="pagination-flat justify-content-center twbs-prev-next pagination">';

        // link a la primera página
        paginador += '<li class="page-item first d-none d-sm-block';
        if (currentpage == 1) {
            paginador += " disabled ";
        }
        paginador +=
            '"><a href="javascript:Fulljaus.changePage(1)" class="page-link legitRipple"><i class="mi-first-page"></i></a></li>';

        // link a la página anterior
        paginador += '<li class="page-item prev d-none d-sm-block';
        if (currentpage == 1) {
            paginador += " disabled ";
        }
        paginador += `"><a href="javascript:Fulljaus.changePage(${
            currentpage - 1
        })" class="page-link legitRipple"><i class="mi-arrow-back"></i></a></li>`;

        var globos_hasta = totalpages;
        var globos_desde = 1;
        if (totalpages > 5) {
            globos_desde = currentpage - 2;
            globos_hasta = currentpage + 2;

            if (globos_desde < 1) {
                var dif = globos_desde - 1;
                globos_desde = 1;
                globos_hasta -= dif;
            }

            if (globos_hasta > totalpages) {
                dif = globos_hasta - totalpages;
                globos_hasta = totalpages;
                globos_desde -= dif;
            }
        }

        for (var i = globos_desde; i <= globos_hasta; i++) {
            var active = "";
            if (i == currentpage) {
                active = "active";
            }
            paginador += `<li class="page-item ${active}"><a href="javascript:Fulljaus.changePage(${i})" class="page-link legitRipple">${i}</a></li>`;
        }

        // link a la siguiente página
        paginador += '<li class="page-item last d-none d-sm-block';
        if (currentpage == totalpages) {
            paginador += " disabled ";
        }
        paginador += `"><a href="javascript:Fulljaus.changePage(${
            currentpage + 1
        })" class="page-link legitRipple"><i class="mi-arrow-forward"></i></a></li>`;

        // link a la última página
        paginador += '<li class="page-item last d-none d-sm-block';
        if (currentpage == totalpages) {
            paginador += " disabled ";
        }
        paginador += `"><a href="javascript:Fulljaus.changePage(${totalpages})" class="page-link legitRipple"><i class="mi-last-page"></i></a></li>`;

        paginador += "</ul>";

        return paginador;
    },

    paginateHtml: function (totalpages, currentpage) {
        namepage = $("#sortable-data").attr("data-page"),
        html = '<select class="paginate_combo form-control custom-select">';
        for (i = 1; i <= totalpages; i++) {
            if (i == currentpage) {
                html += `<option value="${i}" selected="selected">${namepage} ${i}</option>`;
            } else {
                html += `<option value="${i}">${namepage} ${i}</option>`;
            }
        }
        html += "</select>";

        return html;
    },
    eventsHtml: function () {
        $(".paginate_combo").select2();
        $(".paginate_combo").on("change", function () {
            idpage = $(this).val();
            Fulljaus.refreshData();
            $(this).blur();
        });
        $(".row-select2").select2();
    },
    changePage: function (nro_page) {
        idpage = nro_page;
        Fulljaus.refreshData();
    },
};
