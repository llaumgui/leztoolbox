{def $color_scheme = 'light'}
{if $block.custom_attributes.color_scheme|ne('')}{set $color_scheme = $block.custom_attributes.color_scheme}{/if}
<!-- BLOCK: START -->

<div class="block-type-facebook_likebox" id="facebook_likebox_{$block.id}">
{if $block.name|ne('')}
<div class="attribute-header">
    <h2>{$block.name|wash()}</h2>
</div>
{/if}
<div class="block-content">

<div class="columns-two">
<div class="col-1">
<div class="col-content">
    <p id="replace_facebook_likebox_{$block.id}"><img src={"ajax-loader.gif"|ezimage()} alt="{'Loading'|i18n('design/ezfluxbb/login_box')}" /></p>
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){ldelim}$object_code='<iframe src="http://www.facebook.com/plugins/likebox.php?href={$block.custom_attributes.url_to_fanpage|urlencode()}&amp;colorscheme={$color_scheme}&amp;show_faces={$block.custom_attributes.show_faces}&amp;stream={$block.custom_attributes.show_stream}&amp;header={$block.custom_attributes.show_header}&amp;width={$block.custom_attributes.width}&amp;height={$block.custom_attributes.height}" style="border:none;overflow:hidden;width:{$block.custom_attributes.width}px;height:{$block.custom_attributes.height}px"><\/iframe>';$('#replace_facebook_likebox_{$block.id}').replaceWith($object_code);{rdelim});
//]]></script>
</div>
</div>
</div>

</div>

</div>

<!-- BLOCK: END -->
{undef $color_scheme}