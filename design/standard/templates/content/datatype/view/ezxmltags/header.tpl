{if is_set($anchor_name)}<a name={$anchor_name} />{/if}
<a name="eztoc{$toc_anchor_name}" id="eztoc{$toc_anchor_name}" title="{$content}"></a>
{switch name=sw match=$level}
{case match=1}
<h2{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h2>
{/case}
{case match=2}
<h3{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h3>
{/case}
{case match=3}
<h4{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h4>
{/case}
{case match=4}
<h5{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h5>
{/case}
{case match=5}
<h6{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h6>
{/case}
{case match=6} {* html does not have h7 *}
<h6{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h6>
{/case}
{case}
<h2{section show=ne($classification|trim,'')} class="{$classification|wash}"{/section}>{$content}</h2>
{/case}
{/switch}
