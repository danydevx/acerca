<?php

namespace Modules\ListingLeads\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Listings\Models\Listing;
use Modules\ListingLeads\Models\ListingLead;

class MinisiteContactController extends Controller
{
    public function contact(string $slug, Request $request)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('contact_form', $modules)) {
            abort(404);
        }

        return inertia('Public/Business/Contact', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'email' => $business->email,
                'phone' => $business->phone,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'theme' => $business->minisiteTheme ? [
                'id' => $business->minisiteTheme->id,
                'name' => $business->minisiteTheme->name,
                'slug' => $business->minisiteTheme->slug,
                'css_variables' => $business->minisiteTheme->css_variables,
                'layout_config' => $business->minisiteTheme->layout_config,
                'section_config' => $business->minisiteTheme->section_config,
            ] : null,
            'theme_css_variables' => $business->minisiteTheme?->css_variables ? json_encode($business->minisiteTheme->css_variables) : null,
            'modules' => $modules,
            'branding' => [
                'generated_css' => $business->brandingSetting?->generated_css,
                'page_style' => $business->brandingSetting?->page_style,
                'section_style' => $business->brandingSetting?->section_style,
                'hero_style' => $business->brandingSetting?->hero_style,
                'buttons_uppercase' => $business->brandingSetting?->buttons_uppercase,
                'dark_mode' => $business->brandingSetting?->dark_mode,
            ],
            'socialNetworks' => [],
            'locations' => [],
        ]);
    }

    public function storeContact(string $slug, Request $request): RedirectResponse
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('contact_form', $modules)) {
            abort(404);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $lead = ListingLead::create([
            'listing_id' => $business->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'notes' => $data['message'],
            'source' => 'website',
            'status' => 'new',
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
    }

    public function formByShortcode(string $slug, string $shortcode, Request $request)
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('contact_form', $modules)) {
            abort(404);
        }

        $form = $business->contactForms()->where('shortcode', $shortcode)->first();

        if (! $form) {
            abort(404);
        }

        $fields = $form->activeFields->map(fn ($field) => [
            'id' => $field->id,
            'name' => $field->field_name,
            'type' => $field->field_type,
            'label' => $field->label,
            'placeholder' => $field->placeholder,
            'is_required' => $field->is_required,
            'options' => $field->options ?? [],
        ]);

        $theme = $business->minisiteTheme;
        $brandingSetting = $business->brandingSetting;
        $socialNetworks = in_array('socialmedia', $modules)
            ? $business->socialNetworks()->where('is_active', true)->orderBy('sort_order')->get(['id', 'platform', 'url', 'username', 'show_on_hero', 'show_on_footer', 'show_on_contact'])
            : [];
        $locations = $business->locations()->where('is_active', true)->orderBy('is_primary', 'desc')->get(['id', 'name', 'address_line_1', 'city']);

        return inertia('Public/Business/FormByShortcode', [
            'business' => [
                'id' => $business->id,
                'name' => $business->name,
                'slug' => $business->slug,
                'email' => $business->email,
                'phone' => $business->phone,
                'logo_path' => $business->logo_path,
                'website' => $business->website,
            ],
            'form' => [
                'id' => $form->id,
                'name' => $form->name,
                'description' => $form->description,
                'shortcode' => $form->shortcode,
                'success_message' => $form->success_message,
                'show_phone' => $form->show_phone,
                'show_email' => $form->show_email,
            ],
            'fields' => $fields,
            'theme' => $theme ? [
                'id' => $theme->id,
                'name' => $theme->name,
                'slug' => $theme->slug,
                'css_variables' => $theme->css_variables,
                'layout_config' => $theme->layout_config,
                'section_config' => $theme->section_config,
            ] : null,
            'theme_css_variables' => $theme?->css_variables ? json_encode($theme->css_variables) : null,
            'modules' => $modules,
            'branding' => [
                'generated_css' => $brandingSetting?->generated_css,
                'page_style' => $brandingSetting?->page_style,
                'section_style' => $brandingSetting?->section_style,
                'hero_style' => $brandingSetting?->hero_style,
                'buttons_uppercase' => $brandingSetting?->buttons_uppercase,
                'dark_mode' => $brandingSetting?->dark_mode,
            ],
            'socialNetworks' => $socialNetworks,
            'locations' => $locations,
        ]);
    }

    public function storeFormByShortcode(string $slug, string $shortcode, Request $request): RedirectResponse
    {
        $business = Listing::where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $business->modules()->where('is_enabled', true)->get()->pluck('moduleDefinition.key')->toArray();
        if (! in_array('contact_form', $modules)) {
            abort(404);
        }

        $form = $business->contactForms()->where('shortcode', $shortcode)->first();

        if (! $form) {
            abort(404);
        }

        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:50'],
        ];

        $fields = $form->activeFields;
        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $fieldRules = [];

            if ($field->is_required && ! in_array($field->field_type, ['checkbox'])) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            if ($field->field_type === 'email' && $fieldName !== 'email') {
                $fieldRules[] = 'email';
            }

            $rules[$fieldName] = $fieldRules;
        }

        $data = $request->validate($rules);

        $metadata = [];

        foreach ($form->activeFields as $field) {
            if (in_array($field->field_name, ['name', 'email', 'phone'])) {
                continue;
            }

            $value = $data[$field->field_name] ?? null;

            if ($field->field_type === 'checkbox') {
                $value = $request->has($field->field_name) ? 'Si' : 'No';
            }

            if ($value !== null) {
                if ($field->field_type === 'select' && is_array($value)) {
                    $value = implode(', ', $value);
                }
                $metadata[$field->field_name] = $value;
            }
        }

        $lead = ListingLead::create([
            'listing_id' => $business->id,
            'business_contact_form_id' => $form->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'notes' => null,
            'metadata' => $metadata,
            'source' => 'form:'.$form->shortcode,
            'status' => 'new',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', $form->success_message ?? 'Mensaje enviado correctamente.');
    }
}