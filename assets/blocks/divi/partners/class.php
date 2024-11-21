<?php

namespace diviBlock;

if (!class_exists('\ET_Builder_Module')) {
    return;
}

class ExampleBlock extends \ET_Builder_Module
{
    public function init()
    {
        $this->name = esc_html__('Partners', 'accutitle');
        $this->slug = 'accutitle-partners';
        $this->vb_support = 'on';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'elements' => __('Elements', 'accutitle'),
                ],
            ]
        ];
    }

    /**
     * Get the settings fields data for this element.
     * @return array[] {
     *     Settings Fields
     *
     * @type mixed[] $setting_field_key {
     *         Setting Field Data
     *
     * @type string $type Setting field type.
     * @type string $id CSS id for the setting.
     * @type string $label Text label for the setting. Translatable.
     * @type string $description Description for the settings. Translatable.
     * @type string $class Optional. Css class for the settings.
     * @type string[] $affects Optional. The keys of all settings that depend on this setting.
     * @type string[] $depends_on Optional. The keys of all settings that this setting depends on.
     * @type string $depends_show_if Optional. Only show this setting when the settings
     *                                             on which it depends has a value equal to this.
     * @type string $depends_show_if_not Optional. Only show this setting when the settings
     *                                             on which it depends has a value that is not equal to this.
     */
    public function get_fields()
    {
        $fields = [
            'title' => [
                'label' => esc_html__('Title', 'accutitle'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug' => 'text',
            ],
        ];
        return $fields;
    }

    /**
     * @param array $attrs List of unprocessed attributes.
     * @param string $content Content being processed.
     * @param string $render_slug Slug of module that is used for rendering output.
     *
     * @return string The module's HTML output.
     */
    public function render($unprocessed_props, $content, $render_slug)
    {
        $args = [
            'content' => $this->content,
            'title' => $this->props['title'],
        ];

        ob_start();
        get_template_part(
            str_replace(get_stylesheet_directory() . DIRECTORY_SEPARATOR, '', __DIR__) . '/template',
            null,
            $args
        );
        return ob_get_clean();
    }
}
