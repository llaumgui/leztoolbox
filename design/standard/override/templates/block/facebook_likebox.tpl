{def $color_scheme = 'light'}
{if $block.custom_attributes.color_scheme|ne('')}{set $color_scheme = $block.custom_attributes.color_scheme}{/if}
<div class="block-type-facebook_likebox" id="facebook_likebox_{$block.id}">
    <div id="replace_facebook_likebox_{$block.id}"></div>
    <script type="text/javascript">//<![CDATA[
        $(document).ready(function(){ldelim}$object_code='<object data="http://www.facebook.com/plugins/likebox.php?href={$block.custom_attributes.url_to_fanpage|urlencode}&amp;show_faces={$block.custom_attributes.show_faces}&amp;width=100%&amp;colorscheme={$color_scheme}&amp;&amp;stream={$block.custom_attributes.show_stream}&amp;header={$block.custom_attributes.show_header}" style="border:none;overflow:hidden;width:100%;"></object>';$('#replace_facebook_likebox_{$block.id}').replaceWith($object_code);{rdelim});
    //]]></script>
</div>
{undef $color_scheme}