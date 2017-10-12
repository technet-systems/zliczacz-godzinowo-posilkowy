<script>
    $(document).ready(function() {
        // Animowany preloader do momentu wczytania całej strony http://stackoverflow.com/questions/11072759/display-a-loading-bar-before-the-entire-page-is-loaded
        $(".preload").fadeOut(2000, function() {
            $(".container-fluid").fadeIn(1000);

        });
        // /.Animowany preloader do momentu wczytania całej strony http://stackoverflow.com/questions/11072759/display-a-loading-bar-before-the-entire-page-is-loaded

        // Tooltipy
        $('#reset_year').tooltip();
        
        $('#current_month').tooltip();
        // /.Tooltip
        
        $('select').css('text-transform', 'uppercase');
        
        // Rozwijanie bocznego menu w zależności od pierwszego segmentu URL'a
        var pathName = window.location.pathname;
        
        var partPathName = pathName.split('/')[1];
        
        if(partPathName == 'dashboard') {
            $('#dashboard-menu').addClass('in');
            
        } else if(partPathName == 'troop' || partPathName == 'preschooler') {
            $('#accounts-menu').addClass('in');
            
        } else if(partPathName == 'meal' || partPathName == 'stay' || partPathName == 'month') {
            $('#legal-menu').addClass('in');
            
        }
        // /.Rozwijanie bocznego menu w zależności od pierwszego segmentu URL'a

    });
</script>

</body>
</html>