<?PHP

function add_to_a_log($name, $ip, $host, $timestamp, $location)
{
    if (filesize($location) == 0)
    {
        $xml_header = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<entries>\n";
        $fp = fopen($location, 'w');
        fwrite($fp, $xml_header);
        fclose($fp);
    }
    
    $gbXML = new gbXML('entries', 'entry', $location);
    $id = $gbXML->get_max_value_for_tag('id');
    ++$id;
    $tmpArray = array (
        'id' => $id,
        'name' => $name,
        'ip' => $ip,
        'host' => $host,
        'timestamp' => $timestamp
    );
    $gbXML->append_record_to_file($tmpArray);  
}

function add_to_spam_log($name, $ip, $host, $timestamp){
    add_to_a_log($name, $ip, $host, $timestamp, 'data/message_spam.xml');
    return;
}
function add_to_post_log($name, $ip, $host, $timestamp){
    add_to_a_log($name, $ip, $host, $timestamp, 'data/message_post.xml');
}
?>