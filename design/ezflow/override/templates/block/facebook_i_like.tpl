{def $layout_style = 'standard'
     $verb_to_display = 'like'
     $color_scheme = 'light'
}
{if $block.custom_attributes.layout_style|ne('')}{set $layout_style = $block.custom_attributes.layout_style}{/if}
{if $block.custom_attributes.verb_to_display|ne('')}{set $verb_to_display = $block.custom_attributes.verb_to_display}{/if}
{if $block.custom_attributes.color_scheme|ne('')}{set $color_scheme = $block.custom_attributes.color_scheme}{/if}
<div class="block-type-facebook_ilike" id="facebook_ilike_{$block.id}">
    <div id="replace_facebook_ilike_{$block.id}"></div>
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){ldelim} $object_code='<iframe src="http://www.facebook.com/plugins/like.php?href={$block.custom_attributes.url_to_like}&amp;layout={$layout_style}&amp;show_faces={$block.custom_attributes.show_faces}&amp;width=100%&amp;action={$verb_to_display}&amp;font=&amp;colorscheme={$color_scheme}&amp;height={$block.custom_attributes.height}" style="border:none;overflow:hidden;width:100%;height:{$block.custom_attributes.height}px;"></iframe>';$('#replace_facebook_ilike_{$block.id}').replaceWith($object_code);{rdelim});
//]]></script>
</div>
{undef $layout_style $verb_to_display $color_scheme}