<?php

return [
    'bootstrap' => ['css' => ['css/bootstrap.min.css'], 'js' => 'js/bootstrap.min.js', 'pos' => CClientScript::POS_HEAD],
    'hello' => ['css' => '', 'js' => 'dist/hello.all.min.js', 'pos' => CClientScript::POS_HEAD],
    'ladda-bootstrap' => ['css' => 'ladda-themeless.min.css', 'js' => ['spin.min.js', 'ladda.min.js'], 'pos' => CClientScript::POS_END],
    'alertify-dialog' => ['css' => ['themes/alertify.min.css', 'themes/alertify.core.css'], 'js' => ['lib/alertify.js', 'src/alert_custom.js'], 'pos' => CClientScript::POS_HEAD],
    'toast-message' => ['js' => 'simply-toast.min.js', 'css' => 'simply-toast.min.css', 'pos' => CClientScript::POS_HEAD],
    'select2' => ['js' => 'select2.min.js', 'css' => 'select2-bootstrap.css', 'pos' => CClientScript::POS_HEAD],
    'bootstrap-datepicker' => ['js' => 'js/bootstrap-datepicker.js', 'css' => 'css/datepicker.css'],
    'owl' => ['js' => 'js/owl.carousel.min.js', 'css' => 'css/owl.carousel.css'],
];