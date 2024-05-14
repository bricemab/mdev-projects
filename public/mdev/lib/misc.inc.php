<?php

function _t($s) {
    return str_replace("\n", "<br />", $s);
}

function _textWithUrl($text) {
    return preg_replace('/https{0,1}:\/\/([\w\-\.\/#?&=:]*)|(www.[\w\-\.\/#?&=:]*)/',
        '<a href="//$1$2" target="_blank" class="url-in-text">$0</a>', $text);
}

function _cl() {
    return "<div class='clear'></div>";
}