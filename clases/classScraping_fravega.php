<?php
    require_once 'lib/simple_html_dom.php';
    require_once 'classProducto.php';
    require_once 'classDetalleProducto.php';

    class ScrapingFravega
    {
        function obtenerProductos($productoBuscado)
        {
            $parseProductoBuscado = str_replace(' ', '%20', $productoBuscado);
            $url = 'https://www.fravega.com/' . $parseProductoBuscado;
            $listaProductos = array();

            $html = file_get_html($url);

            $container = $html->find('div[class=shelf-resultado n3colunas]', 0);
            $ulList = $container->find('ul');

            foreach($ulList as $ulItem)
            {

                $liList = $ulItem->find('li');

                foreach($liList as $item)
                {
                    if(count($listaProductos) == 10)
                    {
                        break 2;
                    }
                    $divWrap = $item->find('div[class=wrapData]', 0);
                    if(isset($divWrap))
                    {
                        $h2 = $divWrap->find('h2', 0);
                        $a = $h2->find('a', 0);
                        $nombre = $a->innertext;
                        $precio = $item->find('div[class=wrapData]', 0)->find('span[class=prodPrice]', 0)->find('em[class=BestPrice]', 0)->innertext;
                        $imagen = $item->find('div[class=image]', 0)->find('a', 0)->find('img', 0)->src;
                        $link = $item->find('div[class=wrapData]', 0)->find('h2', 0)->find('a', 0)->href;
                        if(strpos($precio, ',') !== false) $precio = substr($precio, 0, strpos($precio, ','));

                        $producto = new Producto;
                        $producto->nombre = $nombre;
                        $producto->precio = str_replace('$', '', $precio);
                        $producto->precio = str_replace('.', '', $producto->precio);
                        $producto->precio = number_format((float)$producto->precio,2,'.','');
                        $producto->link = $link;
                        $producto->urlImagen = $imagen;
                        $producto->codpagina = 'FRV';              
                        // $producto->pagina = 'Fravega';
                        $producto->pagina = "img/fravegalogo.jpg";
                        $listaProductos[] = $producto;
                    }
                }
            }
            return $listaProductos;
        }

         function obtenerDetalleProducto($urlProducto)
        {
            $html = file_get_html($urlProducto);
            $rating = '';
            $listado = array();

            if(isset($html))
            {
                $container = $html->find('div[id=caracteristicas]', 0);
                if(isset($container))
                {
                    $filas = $container->find('tr');
                    if(isset($filas))
                    {
                        foreach($filas as $fila)
                        {
                            $clave = $fila->find('th', 0)->innertext;
                            $valor = $fila->find('td', 0)->innertext;
                            $listado[$clave] = $valor;
                        }
                    }
                }
            }

            $detalle = new DetalleProducto;
            $detalle->rating = $rating;
            $detalle->caracteristicas = $listado;

            return $detalle;
        }
    }
?>