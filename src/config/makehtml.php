<?php
/**
 * TaylorNetwork Make HTML Trait Config
 *
 * @author Sam Taylor
 */

return [

    /* 
     |--------------------------------------------------------------------------
     | Link Attribute Options
     |--------------------------------------------------------------------------
     |
     | Associative array of options to use with Nahid\Linkify see
     | https://github.com/nahid/linkify for usage options
     | 
     */
    'linkifyAttributes' => [
        'target' => '_blank',
    ],

    /*
     |--------------------------------------------------------------------------
     | Void/Singleton HTML Tags
     |--------------------------------------------------------------------------
     |
     | HTML tags that don't get a closing tag.
     |
     */
    'voidTags' => [
        'area',
        'base',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'param',
        'source',
    ],

    /*
     |--------------------------------------------------------------------------
     | External Key Word
     |--------------------------------------------------------------------------
     |
     | Word that when in $attributes array will be placed with the tags
     | surrounding it.
     |
     | Example:
     |      Using 'external' key word and 'a' tag
     |      $attributes = [ 'class' => 'btn', 'style' => 'height: 100px;', 'external' => 'words' ];
     |
     |      Would produce:
     |      '<a class="btn" style="height: 100px;">words</a>'
     |
     */
    'externalKey' => 'external',

    /*
     |--------------------------------------------------------------------------
     | Open Tag Pattern
     |--------------------------------------------------------------------------
     |
     | What an open tag looks like. 
     | {tag} will be replaced by the tag.
     | {attr} will be replaced by attributes.
     | 
     | Usually '<{tag} {attr}>'
     |
     */
    'openTagPattern' => '<{tag} {attr}>',

    /*
     |--------------------------------------------------------------------------
     | Closing Tag Pattern
     |--------------------------------------------------------------------------
     |
     | What a closing tag looks like. 
     | {tag} will be replaced by the tag.
     |
     | Usually '</tag>'
     |
     */
    'closeTagPattern' => '</{tag}>',

    /*
     |--------------------------------------------------------------------------
     | Void Tag Pattern
     |--------------------------------------------------------------------------
     |
     | If different than the opening tag, tags in the voidTags array will
     | use this pattern instead. This is useful if generating XHTML, void tags
     | require trailing slash.
     |
     | HTML 5: '<{tag} {attr}>'
     | XHTML: '<{tag} {attr} />'
     |
     | Note: If left blank, void tags will use the openTagPattern.
     |
     */
    'voidTagPattern' => null,
];