<form class="row" onsubmit="filtrarRecords(); return false;">
    <div class="col-12">
        <input type="text" autocomplete="off" id="searchRecord" class="form-control" placeholder="Buscar">
    </div>
</form>

<script type="text/javascript">

    window.addEventListener('load', function() {

        $.expr[":"].contiene = $.expr.createPseudo(function(arg) {
            return function( elem ) {
                return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });
        
        $('#searchRecord').keyup(function (){ filtrarRecords(); });
    }, false)

    function filtrarRecords(){
        var find = document.getElementById('searchRecord').value.trim();

        if (!find || find == '') {
            $('#{{ $containerid }} .ticket-container').show();
            return;
        }

        $('#{{ $containerid }} .ticket-container').hide();

        var element = $("#{{ $containerid }} .ticket-problem-title:contiene('"+find+"')" ).parents('.ticket-container').show();
        var element = $("#{{ $containerid }} .ticket-problem-description:contiene('"+find+"')" ).parents('.ticket-container').show();
        var element = $("#{{ $containerid }} .ticket-number:contiene('"+find+"')" ).parents('.ticket-container').show();
        var element = $("#{{ $containerid }} .ticket-tag:contiene('"+find+"')" ).parents('.ticket-container').show();
    }
</script>
