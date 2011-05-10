{def $reset_button = true()
     $load_button = true()
     $save_button = true()
}
{if $block.custom_attributes.reset_button|ne('')}{set $reset_button = $block.custom_attributes.reset_button}{/if}
{if $block.custom_attributes.load_button|ne('')}{set $load_button = $block.custom_attributes.load_button}{/if}
{if $block.custom_attributes.save_button|ne('')}{set $save_button = $block.custom_attributes.save_button}{/if}
<!-- BLOCK: START -->

<div class="block-type-ezportal-controls">
{if $block.name|ne('')}
<div class="attribute-header">
    <h2>{$block.name|wash()}</h2>
</div>
{/if}
<div class="block-content">

<div class="columns-two">
<div class="col-1">
<div class="col-content">
    <ul>
        {if $reset_button}<li><span class="ezportal-button" id="portalReset" title="{'Reset preferences'|i18n('block/ezportal','title')}">{'Reset preferences'|i18n('block/ezportal')}</span></li>{/if}
        {if $load_button}<li><span class="ezportal-button" id="portalLoad" title="{'Load preferences'|i18n('block/ezportal','title')}">{'Load preferences'|i18n('block/ezportal')}</span></li>{/if}
        {if $save_button}<li><span class="ezportal-button" id="portalSave" title="{'Save preferences'|i18n('block/ezportal','title')}">{'Save preferences'|i18n('block/ezportal')}</span></li>{/if}
    </ul>
</div>
</div>
</div>

</div>

</div>

<!-- BLOCK: END -->
{undef $reset_button $load_button $save_button}