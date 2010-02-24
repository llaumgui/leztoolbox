{def $n = ''
     $attribute = ''
     $url = false()
     $protocols = array('http', 'file', 'ftp', 'mailto', 'https')
}
{if $protocols|contains( $href|explode(':')|extract_left(1) )not()}
    {set $n=fetch(content, node, hash(node_path, $href))}
    {if and($n, $n.object.class_identifier|eq('file'))}
        {set $attribute=$n.data_map.file}
        {set $url=concat( '/content/download/', $attribute.contentobject_id, '/', $attribute.id,'/version/', $attribute.version , '/file/', $attribute.content.original_filename|urlencode )}
    {/if}
{/if}
{if $url|not()}
    {set $url=$href}
{/if}
<a href={$url|ezurl}{if $id} id="{$id}"{/if}{if $title} title="{$title}"{/if}{if $target|eq('_blank')} target="{$target}"{/if}{if $classification|trim|ne('')} class="{$classification|wash}"{/if}>{$content}</a>{undef $n $attribute $url $protocols}