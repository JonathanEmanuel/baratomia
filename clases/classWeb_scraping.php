<?php
    require_once 'classScraping_alamaula.php';
    require_once 'classScraping_fravega.php';
    require_once 'classScraping_garbarino.php';
    require_once 'classScraping_linio.php';
    require_once 'classScraping_musimundo.php';

    class WebScraping
    {        
        function obtenerProductosAlamaula($busqueda)
        {
            $scraping = new ScrapingAlamaula;
            return $scraping->obtenerProductos($busqueda);
        }

        function obtenerProductosFravega($busqueda)
        {
            $scraping = new ScrapingFravega;
            return $scraping->obtenerProductos($busqueda);
        }

        function obtenerProductosGarbarino($busqueda)
        {
            $scraping = new ScrapingGarbarino;
            return $scraping->obtenerProductos($busqueda);
        }

        function obtenerProductosLinio($busqueda)
        {
            $scraping = new ScrapingLinio;
            return $scraping->obtenerProductos($busqueda);
        }

        function obtenerProductosMusimundo($busqueda)
        {
            $scraping = new ScrapingMusimundo;
            return $scraping->obtenerProductos($busqueda);
        }
    }
?>