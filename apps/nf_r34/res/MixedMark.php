<?php

function MixedMark($string){
    $patterns = array(
        '`\[b\](.+?)\[/b\]`is', 
        '`\[i\](.+?)\[/i\]`is', 
        '`\[u\](.+?)\[/u\]`is', 
        '`\[s\](.+?)\[/s\]`is', 
        '`\[aa\](.+?)\[/aa\]`is', 
        '`\[spoiler\](.+?)\[/spoiler\]`is', 
        '#(http://|https://|ftp://)([^(\s<|\[)]*)#', 
        '`\[code\](.+?)\[/code\]`is',
        '`\*\*(.+?)\\*\*`is', 
        '`\*(.+?)\*`is', 
        '`%%(.+?)\%%`is', 
        '`\`(.+?)\``is', 
        '`&gt;&gt;([0-9]+)`is',
        '`^&gt;(.+?)(\n|\0|$)`im',
        '`([a-z]{2})wiki://(\S*)`is'
        );
    $replaces =  array(
        '<b>\\1</b>', 
        '<i>\\1</i>', 
        '<span style="border-bottom: 1px solid">\\1</span>', 
        '<strike>\\1</strike>', 
        '<div style="font-family: Mona,\'MS PGothic\' !important;">\\1</div>', 
        '<span class="spoiler">\\1</span>', 
        '<a class="link" href="\\1\\2">\\1\\2</a>', 
        '<pre><code>\\1</code></pre>',
        '<b>\\1</b>', 
        '<i>\\1</i>', 
        '<span class="spoiler">\\1</span>', 
        '<pre><code>\\1</code></pre>',
        '<a class="link" href="#\\1">&gt;&gt;\\1</a>',
        '<span class="quote">&gt;\\1</span>',
        '<a class="link" href="https://\\1.wikipedia.org/wiki/\\2">\\1wiki://\\2</a>'
        );
    $string = preg_replace($patterns, $replaces , $string);
    
    return $string;
}
