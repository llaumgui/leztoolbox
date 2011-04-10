{ezscript_require( array(
    'ezjsc::jquery',
    'jquery/jquery.jtweetsanywhere.min.js',
) )}
{def $count = 20}
{if $block.custom_attributes.count|ne('')}{set $count = $block.custom_attributes.count}{/if}
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
<div class="col-content" id="replace_twitterbox_{$block.id}">
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){ldelim}$('#replace_twitterbox_{$block.id}').jTweetsAnywhere({ldelim}searchParams:'{$block.custom_attributes.search_params}',count:{$count}{rdelim});{rdelim});
//]]></script>
</div>
</div>
</div>

</div>

</div>
<!-- BLOCK: END -->
{undef $count}