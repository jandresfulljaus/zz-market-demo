function checkInApp() {
    return /Fulljaus Android/i.test(navigator.userAgent);
}

var Notifications = {
    urlRequest: "/perfil/notificaciones",
    storageName: "BrowserNotifData",
    refreshTime: 5000, // 5 sec
    timer: null,
    data: {},
    clearStoredData: function () {
        localStorage.removeItem(this.storageName);
    },
    init: function (minutes) {
        if (!localStorage.getItem(this.storageName)) {
            localStorage.setItem(this.storageName, '{ "total": 0, "ids": [] }');
        }

        if (minutes) {
            this.refreshTime = minutes * 60 * 1000;
        }

        this.data = JSON.parse(localStorage.getItem(this.storageName));

        this.setTimer(0);
    },
    clearTimer: function () {
        clearTimeout(Notifications.timer);
    },
    setTimer: function (tiempo) {
        this.clearTimer();
        this.timer = setTimeout(this.checkNotifications, tiempo);
    },
    checkNotifications: function () {
        var _this = this;
        $.get(
            Notifications.urlRequest,
            "",
            function (data) {
                Notifications.processResults(data);
            },
            "json"
        );
    }, // checkNotifications
    processResults: function (response) {
        var _this = this;

        // emails sin leer
        if (response.emails.length > 0) {
            var total = 0;
            for (x in response.emails) {
                var cantidad = response.emails[x];
                total += cantidad;
                if (cantidad > 0) {
                    $(".emailNotification" + [x])
                        .html(cantidad)
                        .show();
                }
            }

            if (total > 0) {
                $(".emailNotificationTotal").html(total).show();
            }
        }

        // Expedientes en curso
        if (response.records) {
            $("#recordNotifications").html(response.records);
        }

        // Tickets pendientes
        if (response.tickets) {
            $("#ticketNotifications").html(response.tickets);
        }

        // Mensaje pendientes Web
        if (response.messages) {
            $("#messageNotifications").html(response.messages);
            $(".messageNotifications").html(response.messages);
        }

        // notificaciones generales
        if (response.notifications.length > 0) {
            // badge con número total de notificaciones
            $("#headerNotifications")
                .html(response.notifications.length)
                .show();

            $("#notificationContent").html("");
            for (x in response.notifications) {
                var data = response.notifications[x];

                var icon = "icon-mention";
                var icon_color = "btn-success";
                switch (data.data.module) {
                    case "record":
                        icon = "icon-file-text2";
                        icon_color = "btn-danger";
                        break;
                    case "ticket":
                        icon = "mi-turned-in";
                        icon_color = "btn-info";
                        break;
                }

                var content = data.data.title;
                var howLong = data.howLong;
                var link = `${data.data.url}?n=${data.id}`;

                var nuevo = `<a href="${link}" class="media p-2 m-0">
                                <div class="mr-3">
                                    <span class="btn ${icon_color} rounded-pill btn-icon">
                                        <i class="${icon}"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    ${content}
                                    <div class="font-size-sm text-muted mt-1 text-right">
                                        ${howLong}
                                    </div>
                                </div>
                            </a>`;

                $("#notificationContent").append(nuevo);

                // ver si las notificaciones siguen igual o cambiaron
                // para mandar la notificación nativa del navegador
                if (!_this.data.ids.includes(data.id)) {
                    _this.data.ids.push(data.id);

                    /*
                    // mando la notificación del navegador, si no estoy en la app
                    if (!checkInApp() && cambio) {
                        var cuerpo = 'Tiene '+data.cantidad+' '+cuerpo_tipo;
                        _this.notificacionBrowser({
                            titulo: (data.nombre)?data.nombre:data.tipo,
                            cuerpo: cuerpo,
                            link: ((data.link)?data.link:'<?php echo _TB_HOST; ?>/notificaciones')
                        });
                    }
                    */
                }
            } // for notificaciones
        } // si hay notificaciones
        
        else {
            notificationPending = $("#notificationContent").attr("data-notification"),
            $("#notificationContent").html(
                `<span class="dropdown-item-text">${notificationPending}&hellip;</span>`
            );
        }

        _this.data.total = response.notifications.length;
        localStorage.setItem(this.storageName, JSON.stringify(_this.data));

        _this.setTimer(_this.refreshTime);
    }, // processResults

    // notificaciones nativas del navegador
    notificacionBrowser: function (data) {
        if (Notification) {
            if (Notification.permission !== "granted") {
                Notification.requestPermission();
            }

            if (typeof noti != "undefined") {
                noti.onclose = null;
                noti.close();
            }

            var title = data.titulo ? data.titulo : "Fulljaus :: Notificaciones";
            var extra = {
                icon: "https://www.fulljaus.com/fulljaus/web/Assets/images/favicon.png",
                body: data.cuerpo,
            };

            noti = new Notification(title, extra);

            if (data.link) {
                noti.onclick = function () {
                    event.preventDefault();
                    window.open(data.link, "_blank");
                    noti.onclose = null;
                };
            }
        } // if notificacion
    }, // notificacionBrowser
}; // Notificaciones

// iniciar las notificaciones
Notifications.init(3);
