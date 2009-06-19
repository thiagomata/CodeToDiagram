<?php
/**
 * @package public
 * @subpackage CodeToDiagram
 */

/**
 * This is the footer of all public pages.
 *
 * Until now this only will be used to make the counter of the google analytics
 *
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 *
 */
?>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ?
                            "https://ssl." : "http://www.");
            document.write(
                unescape(
                    "%3Cscript src='" +
                    gaJsHost +
                    "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"
                )
            );
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-8429204-1");
                pageTracker._trackPageview();
            } catch(err) {

            }
        </script>
