/* ------------------------------------------------------------------------------
 *
 *  # Fulljaus
 *
 *  Incluye los controles para que funcione la applicación
 *
 * ---------------------------------------------------------------------------- */

var Fulljaus = {

	popupForm:function()
	{
		return false;
	},

	templateSelectPersons: function (record)
	{

		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
				"<div class='select2-result-repository__meta'>" +
					"<div class='select2-result-repository__title'>"+ record.name + ", " + record.dni +"</div>" +
					"<div class='select2-result-repository__description'>"+ record.city.name + ", " + record.city.region.name +"</div>" +
				"</div>" +
			"</div>"
		);

		return $container;
	},

	templateSelectEmployees: function (record)
	{

		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
				"<div class='select2-result-repository__meta'>" +
					"<div class='select2-result-repository__title'>"+ record.text +"</div>" +
					"<div class='select2-result-repository__description'> Legajo: "+ record.element.dataset.docket + " </div>" +
				"</div>" +
			"</div>"
		);

		return $container;
	},

	templateSelectDepartments: function (record)
	{
		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
						"<div class='select2-result-repository__meta'>" +
								"<div class='select2-result-repository__title'>"+ record.text +"</div>" +
								"<div class='select2-result-repository__description'>"+ record.element.dataset.parent_name +"</div>" +
						"</div>" +
			"</div>"
		);

		return $container;
	},
	/** Conjunto de Métodos */
	refreshData: function()
	{
		var totalpages=1;
		var currentpage=1;

		$.ajax({
			type: 'POST',
			url: route_getdata,
			data: { _token: _token, filter_search: $('#filtersearch').val(), filter_id: $('#filterlist').val(), page: idpage, ordinal_field: ordinal_field, ordinal_order: ordinal_order },
			success: function(response)
			{
				// console.log(response);
				if (typeof response.status != 'undefined')
				{
					if (response.status == 'true')
					{
						if(typeof response.data.data != 'undefined')
						{
							bigdata=response.data.data;
							if(typeof response.data.current_page != 'undefined')
							{
								totalpages=response.data.last_page;
								currentpage = response.data.current_page;
							}

						} else if(typeof response.data != 'undefined')	{
							bigdata=response.data;
						} else {
							bigdata='';
						}


						if (bigdata == '')
						{
							html += '<tr><td colspan="6"><h3 class="text-center">Sin datos para esta selección.</h3></td></tr>';
						} else {
							html=Fulljaus.tableHtml(bigdata);
						}

						$('#sortable-data').html(html).promise().done(function(){
							html2=Fulljaus.paginateHtml(totalpages,currentpage);
							$('.paginate_table').html(html2).promise().done(function(){
								Fulljaus.eventsHtml();
							});
						});

						//Fulljaus.eventsHtml();
					} else {
						alert(response.message);
					}
				} else {
					alert ('Server not respond, please refresh your page');
				}
			},
			error: function (data, textStatus, errorThrown)
			{
				console.log(data);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});

	},
	tableHtml: function(bigdata)
	{
		var html = '';

		$.each(bigdata, function (k, record)
		{
			html += '<tr role="row" id="row-'+record.id+'">';
			var i=0;

			if(sort_field==='true')
			{
				html += '<td class="dragndrop"></td>';
				i++;
			}

			$.each(listfields, function (i, fieldname)
			{
				switch(fieldname)
				{
					case 'status':
						if (record[fieldname] === 1)
						{
							html += '<td><span class="badge bg-purple">Active</span></td>';
						} else {
							html += '<td><span class="badge badge-danger">Inactivo</span></td>';
						}
						break;

					case 'approved':
						if (record[fieldname] === 1)
						{
							html += '<td><span class="badge bg-success">Aprobado</span></td>';
						} else {
							html += '<td><span class="badge badge-warning">Pendiente</span></td>';
						}
						break;

					case 'status2':
						var content_td = '<select id="status'+record.id+'" class="form-control row-select2" data-fouc>';

						if (record[fieldname] === 1)
						{
							content_td += '<option value="1" selected>Activo</option>';
							content_td += '<option value="0">Inactivo</option>';
						} else {
							content_td += '<option value="1">Activo</option>';
							content_td += '<option value="0" selected>Inactivo</option>';

						}
						content_td += '</select>';
						html += '<td>'+content_td+'</td>';

						break;
					case 'startdate':
					case 'enddate':
					case 'available':
					case 'accredited':
					case 'created_at':
						var d = new Date(record[fieldname]);
						html += '<td>'+d.toLocaleDateString('es-AR');+'</td>';
						break;
					default:
						html += '<td>';
						var content_td = '';
						var start_united=['<div class="font-weight-semibold">','<div class="text-muted">'];
						var end_united = '</div>';

						var fieldsUnited = fieldname.split('+');
						if(fieldsUnited.length>1)
						{
							$.each(fieldsUnited, function (k, unitedname) {
								var fieldsRelation = unitedname.split('->');
								content_td += start_united[k];
								//var fieldsRelation = unitedname.split('->');
									switch(fieldsRelation.length)
									{
										case 1:
											try{ content_td += record[unitedname]??'&nbsp;'; }catch{}
											break;
										case 2:
											try{ content_td += record[fieldsRelation[0]][fieldsRelation[1]]; }catch{}
											break;
										case 3:
											try{ content_td += record[fieldsRelation[0]][fieldsRelation[1]][fieldsRelation[2]]; }catch{}
											break;
										case 4:
											try{ content_td += record[fieldsRelation[0]][fieldsRelation[1]][fieldsRelation[2]][fieldsRelation[3]]; }catch{}
											break;
									}
								content_td += end_united;
							});
						} else {
							var fieldsRelation = fieldname.split('->');
							switch(fieldsRelation.length)
							{
								case 1:
									try{ content_td = record[fieldname]; }catch{}
									break;
								case 2:
									try{ content_td = record[fieldsRelation[0]][fieldsRelation[1]]; }catch{}
									break;
								case 3:
									try{ content_td = record[fieldsRelation[0]][fieldsRelation[1]][fieldsRelation[2]]; }catch{}
									break;
								case 4:
									try{ content_td = record[fieldsRelation[0]][fieldsRelation[1]][fieldsRelation[2]][fieldsRelation[3]]; }catch{}
									break;
							}
						}

						html += (content_td == null)?'':content_td;
						html += '</td>';
						break;
					}

				});
				html+=Fulljaus.actionTableHtml(record);
				html+="</tr>";
		});
		return html;
	},
	actionTableHtml: function(record)
	{
		action_html = '';

		$.each(model_info['actions'], function (n, action) {

			if(action['type']=='link')
			{
				action_html += '<a href="'+ action["route"]+record.id+'" class="btn p-1 m-1 '+action['icon_class']+'"><i class="'+action['icon']+' text-white"></i></a>';
			}
			if(action['type']=='button')
			{
				aevent=(action['event']!=='undefined')?action['event']:'';
				action_html +='<form action="'+action["route"]+'" method="POST" '+aevent+' style="display: inline"><input type="hidden" name="_token" value="'+_token+'"><input type="hidden" name="id" value="'+record.id+'"><button title="'+action['title']+'" type="submit" class="btn p-1 m-1 '+action['icon_class']+'"><i class="'+action['icon']+' text-white"></i></button></form>';
			}
		});
		return '<td>'+action_html+'</td>';
	},
	paginateHtml: function(totalpages,currentpage)
	{
		html='<select class="paginate_combo form-control custom-select">';
		for(i=1; i<=totalpages; i++)
		{
			if(i==currentpage)
			{
				html+='<option value="' + i + '" selected="selected">Página ' + i + '</option>';
			} else {
				html+='<option value="' + i + '">Página ' + i + '</option>';
			}
		}
		html += '</select>';
		return html;

	},
	eventsHtml: function() {
		$('.paginate_combo').select2();
		$('.paginate_combo').on('change', function() {
			idpage=$(this).val();
			Fulljaus.refreshData();
			$(this).blur();
		});
		$('.row-select2').select2();
	}
};
