<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <script>
        function substitutePdfVariables() {
            function getParameterByName(name) {
                var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
                return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
            }
            function substitute(name) {
                var value = getParameterByName(name);
                var elements = document.getElementsByClassName(name);

                for (var i = 0; elements && i < elements.length; i++) {
                    elements[i].textContent = value;
                }
            }
            ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection']
                .forEach(function(param) {
                    substitute(param);
                });
        }
    </script>
</head>
<body onload="substitutePdfVariables()">
<div style="padding-bottom: 25px; text-align: right">
    <label style="font-size: 9px;">Pag <span class="page"></span> de <span class="topage"></span></label>
</div>
</body>
</html>
