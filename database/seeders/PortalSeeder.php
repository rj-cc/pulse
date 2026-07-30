<?php

namespace Database\Seeders;

use App\Enums\PortalColorPalette;
use App\Enums\PortalFontStyle;
use App\Enums\PortalSectionLayout;
use App\Models\PortalSection;
use App\Models\PortalSectionItem;
use App\Models\PortalSetting;
use App\Models\SidebarItem;
use App\Models\SidebarSection;
use Illuminate\Database\Seeder;

class PortalSeeder extends Seeder
{
    public function run(): void
    {
        PortalSetting::query()->delete();
        PortalSectionItem::query()->delete();
        PortalSection::query()->delete();
        SidebarItem::query()->delete();
        SidebarSection::query()->delete();

        PortalSetting::query()->create([
            'organization_name' => 'Lorem Organization',
            'organization_tagline' => 'Employee Portal · Lorem Ipsum',
            'logo_path' => null,
            'topbar_phone' => 'Trunkline: (+632) 0000-0000',
            'topbar_email' => 'contact@example.com',
            'topbar_right_label' => 'Lorem Organization',
            'hero_subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'hero_motto' => 'Sed do eiusmod tempor incididunt ut labore.',
            'footer_motto' => 'Ut enim ad minim veniam, quis nostrud exercitation.',
            'footer_copyright' => '© '.now()->year.' Lorem Organization. Internal use only.',
            'footer_right_label' => 'Lorem Organization',
            'footer_links' => [
                ['label' => 'About', 'url' => '#'],
                ['label' => 'Privacy', 'url' => '#'],
                ['label' => 'Terms of Service', 'url' => '#'],
                ['label' => 'Contact Us', 'url' => '#'],
            ],
            'color_palette' => PortalColorPalette::NavyGold,
            'font_style' => PortalFontStyle::ManropeFraunces,
        ]);

        $announcements = PortalSection::query()->create([
            'title' => 'Announcements',
            'layout' => PortalSectionLayout::Carousel,
            'is_published' => true,
            'sort_order' => 1,
        ]);

        $announcementItems = [
            [
                'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit',
                'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'badges' => [
                    ['label' => 'Important', 'style' => 'important'],
                    ['label' => 'New', 'style' => 'new'],
                ],
                'meta_text' => '1 day ago',
                'accent_color' => '#C8102E',
                'sort_order' => 1,
            ],
            [
                'title' => 'Ut enim ad minim veniam quis nostrud exercitation',
                'body' => '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                'badges' => [
                    ['label' => 'New', 'style' => 'new'],
                ],
                'meta_text' => '2 days ago',
                'accent_color' => '#143A75',
                'sort_order' => 2,
            ],
            [
                'title' => 'Duis aute irure dolor in reprehenderit in voluptate',
                'body' => '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
                'badges' => [
                    ['label' => 'Event', 'style' => 'event'],
                ],
                'meta_text' => '4 days ago',
                'accent_color' => '#F2C14E',
                'sort_order' => 3,
            ],
            [
                'title' => 'Excepteur sint occaecat cupidatat non proident sunt',
                'body' => '<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'badges' => [
                    ['label' => 'New', 'style' => 'new'],
                ],
                'meta_text' => '5 days ago',
                'accent_color' => '#1E4A8C',
                'sort_order' => 4,
            ],
        ];

        foreach ($announcementItems as $item) {
            PortalSectionItem::query()->create([
                ...$item,
                'portal_section_id' => $announcements->id,
                'opens_modal' => true,
                'is_published' => true,
                'published_at' => now()->subDays($item['sort_order']),
            ]);
        }

        $systems = PortalSection::query()->create([
            'title' => 'Systems',
            'layout' => PortalSectionLayout::IconGrid,
            'view_all_label' => 'View all',
            'initial_items_count' => 4,
            'collapse_label' => 'Show less',
            'is_published' => true,
            'sort_order' => 2,
        ]);

        $systemItems = [
            ['title' => 'Lorem Ipsum', 'subtitle' => 'Dolor sit amet', 'icon' => 'file-text', 'accent_color' => '#143A75', 'url' => '#', 'sort_order' => 1],
            ['title' => 'Consectetur', 'subtitle' => 'Adipiscing elit', 'icon' => 'heart', 'accent_color' => '#C8102E', 'url' => '#', 'sort_order' => 2],
            ['title' => 'Sed Do', 'subtitle' => 'Eiusmod tempor', 'icon' => 'landmark', 'accent_color' => '#D4A62A', 'url' => '#', 'sort_order' => 3],
            ['title' => 'Incididunt', 'subtitle' => 'Ut labore', 'icon' => 'calendar-days', 'accent_color' => '#2E7D4F', 'url' => '#', 'sort_order' => 4],
            ['title' => 'Dolore Magna', 'subtitle' => 'Aliqua ut enim', 'icon' => 'chart-bar', 'accent_color' => '#1E4A8C', 'url' => '#', 'sort_order' => 5],
            ['title' => 'Veniam Quis', 'subtitle' => 'Nostrud exercitation', 'icon' => 'ellipsis', 'accent_color' => null, 'url' => '#', 'is_featured' => true, 'sort_order' => 6],
        ];

        foreach ($systemItems as $item) {
            PortalSectionItem::query()->create([
                ...$item,
                'portal_section_id' => $systems->id,
                'opens_modal' => false,
                'is_published' => true,
                'is_featured' => $item['is_featured'] ?? false,
            ]);
        }

        $mustKnow = PortalSection::query()->create([
            'title' => 'Must Know',
            'layout' => PortalSectionLayout::InfoGrid,
            'view_all_label' => 'View all',
            'initial_items_count' => 3,
            'collapse_label' => 'Show less',
            'is_published' => true,
            'sort_order' => 3,
        ]);

        $mustKnowItems = [
            [
                'title' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do',
                'body' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'tag_label' => 'Memo',
                'tag_style' => 'memo',
                'meta_text' => '2 days ago',
                'accent_color' => '#143A75',
                'sort_order' => 1,
            ],
            [
                'title' => 'Ut enim ad minim veniam quis nostrud exercitation ullamco',
                'body' => '<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                'tag_label' => 'Deadline',
                'tag_style' => 'deadline',
                'meta_text' => '4 days remaining',
                'accent_color' => '#C8102E',
                'sort_order' => 2,
            ],
            [
                'title' => 'Duis aute irure dolor in reprehenderit in voluptate velit',
                'body' => '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
                'tag_label' => 'Spotlight',
                'tag_style' => 'spotlight',
                'meta_text' => 'Share recognition',
                'accent_color' => '#2E7D4F',
                'sort_order' => 3,
            ],
            [
                'title' => 'Excepteur sint occaecat cupidatat non proident sunt in culpa',
                'body' => '<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>',
                'tag_label' => 'Update',
                'tag_style' => 'new',
                'meta_text' => '1 week ago',
                'accent_color' => '#1E4A8C',
                'sort_order' => 4,
            ],
        ];

        foreach ($mustKnowItems as $item) {
            PortalSectionItem::query()->create([
                ...$item,
                'portal_section_id' => $mustKnow->id,
                'opens_modal' => true,
                'is_published' => true,
                'published_at' => now()->subDays($item['sort_order']),
            ]);
        }

        $quickAccess = SidebarSection::query()->create([
            'title' => 'Quick Access',
            'icon' => 'zap',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        foreach ([
            ['title' => 'Lorem Ipsum', 'subtitle' => 'Dolor sit amet consectetur', 'icon' => 'id-card', 'url' => '#', 'sort_order' => 1],
            ['title' => 'Adipiscing Elit', 'subtitle' => 'Sed do eiusmod tempor', 'icon' => 'clock', 'url' => '#', 'sort_order' => 2],
            ['title' => 'Incididunt Labore', 'subtitle' => 'Ut enim ad minim', 'icon' => 'ticket', 'url' => '#', 'sort_order' => 3],
        ] as $item) {
            SidebarItem::query()->create([
                ...$item,
                'sidebar_section_id' => $quickAccess->id,
                'is_published' => true,
            ]);
        }

        $birthdays = SidebarSection::query()->create([
            'title' => 'Birthdays This Week',
            'icon' => 'cake',
            'is_published' => true,
            'sort_order' => 2,
        ]);

        foreach ([
            ['title' => 'Lorem Ipsum', 'subtitle' => 'Monday · Dolor Division', 'avatar_text' => 'LI', 'sort_order' => 1],
            ['title' => 'Dolor Sit', 'subtitle' => 'Wednesday · Amet Division', 'avatar_text' => 'DS', 'sort_order' => 2],
            ['title' => 'Consectetur Elit', 'subtitle' => 'Friday · Sed Division', 'avatar_text' => 'CE', 'sort_order' => 3],
        ] as $item) {
            SidebarItem::query()->create([
                ...$item,
                'sidebar_section_id' => $birthdays->id,
                'icon' => null,
                'url' => null,
                'is_published' => true,
            ]);
        }

        $help = SidebarSection::query()->create([
            'title' => 'Help',
            'icon' => 'life-buoy',
            'is_published' => true,
            'sort_order' => 3,
        ]);

        foreach ([
            ['title' => 'Lorem Support', 'subtitle' => 'Ext. 1234', 'icon' => 'headset', 'sort_order' => 1],
            ['title' => 'Ipsum Helpdesk', 'subtitle' => 'help@example.com', 'icon' => 'users', 'sort_order' => 2],
            ['title' => 'Dolor Security', 'subtitle' => 'security@example.com', 'icon' => 'shield', 'sort_order' => 3],
        ] as $item) {
            SidebarItem::query()->create([
                ...$item,
                'sidebar_section_id' => $help->id,
                'url' => null,
                'is_published' => true,
            ]);
        }
    }
}
