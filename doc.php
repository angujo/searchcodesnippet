
<?php 
function highlightMatch($search, $string)
{
    $search_text = array_map('trim', explode(' ', trim($search)));
    foreach ($search_text as $txt) {
        $string = singleHighlight($txt, $string);
    }
    return $string;
}

function singleHighlight($search, $string)
{
    $wordToFind  = trim($search);
    $wrap_before = '<span class="highlight-match">';
    $wrap_after  = '</span>';

    return preg_replace("/($wordToFind)/i", "$wrap_before$1$wrap_after", $string);
}

function searchDescription($term, $description, $substring_count = 100)
{
    $search_text   = array_map('trim', explode(' ', trim($term)));
    $length        = strlen($description);
    $firstPosition = FALSE;
    if ($substring_count < $length) {
        foreach ($search_text as $txt) {
            if (FALSE !== stripos($description, trim($txt))) {
                if (FALSE === $firstPosition || $firstPosition > stripos($description, trim($txt))) {
                    $firstPosition = stripos($description, trim($txt));
                }
            }
        }
    } else {
        $firstPosition = 0;
    }
    if (0 != $firstPosition) {
        $remaining = $length - $firstPosition;
        if ($remaining < $substring_count) {
            $firstPosition = $firstPosition - ($substring_count/2 - strlen($term));
        }
    }
    return (FALSE !== $firstPosition && 0 < $firstPosition ? '...' : '') .
           sub_string(substr($description, $firstPosition, $length), $substring_count);
}