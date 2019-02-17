<?php
/**
 * TaylorNetwork Make HTML Trait Config.
 *
 * @author Sam Taylor
 */

return [

    /*
     |--------------------------------------------------------------------------
     | Link Attributes
     |--------------------------------------------------------------------------
     |
     | Associative array of options to add to all links generated.
     |
     | Note: These will override any attributes set in class, DO NOT add
     | href or external (or whatever your external key is) to this array.
     | Those will override whatever the generator generates.
     |
     */
    'linkAttributes' => [
        'target' => '_blank',
    ],

    /*
     |--------------------------------------------------------------------------
     | Default Generator Actions
     |--------------------------------------------------------------------------
     |
     | When running makeHTML() on the generator, do all actions or just some?
     | If customActions are enabled you can define custom methods to call
     | that are defined in the parent class.
     |
     */
    'defaultActions' => [
        'makeLinks'          => true,
        'convertLineEndings' => true,
    ],

    /*
     |--------------------------------------------------------------------------
     | Void/Singleton HTML Tags
     |--------------------------------------------------------------------------
     |
     | HTML tags that don't get a closing tag.
     |
     */
    'voidTags' => ['area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source'],

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
