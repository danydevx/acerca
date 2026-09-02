import { defineConfig } from 'vitepress'

export default defineConfig({
  title: 'ORP UI',
  description: 'Mobile-first UI framework for Vue 3 applications',
  lang: 'en-US',

  head: [
    ['link', { rel: 'icon', href: '/favicon.ico' }],
    ['meta', { name: 'theme-color', content: '#3B82F6' }],
  ],

  themeConfig: {
    logo: '/orp-ui-logo.svg',
    siteTitle: 'ORP UI',

    nav: [
      { text: 'Guide', link: '/guide/introduction', activeMatch: '/guide/' },
      { text: 'Foundations', link: '/foundations/colors', activeMatch: '/foundations/' },
      { text: 'Components', link: '/components/', activeMatch: '/components/' },
      { text: 'Utilities', link: '/utilities/', activeMatch: '/utilities/' },
      { text: 'Integrations', link: '/integrations/', activeMatch: '/integrations/' },
    ],

    sidebar: {
      '/guide/': [
        {
          text: 'Guide',
          items: [
            { text: 'Introduction', link: '/guide/introduction' },
            { text: 'Getting Started', link: '/guide/getting-started' },
            { text: 'Installation', link: '/guide/installation' },
            { text: 'Theming', link: '/guide/theming' },
          ]
        }
      ],
      '/foundations/': [
        {
          text: 'Foundations',
          items: [
            { text: 'Colors', link: '/foundations/colors' },
            { text: 'Typography', link: '/foundations/typography' },
            { text: 'Spacing', link: '/foundations/spacing' },
            { text: 'Tokens', link: '/foundations/tokens' },
            { text: 'Motion', link: '/foundations/motion' },
          ]
        }
      ],
      '/components/': [
        {
          text: 'Actions',
          items: [
            { text: 'Button', link: '/components/button' },
            { text: 'Icon Button', link: '/components/icon-button' },
          ]
        },
        {
          text: 'Layout',
          items: [
            { text: 'Card', link: '/components/card' },
            { text: 'Section', link: '/components/section' },
            { text: 'Stack', link: '/components/stack' },
            { text: 'Cluster', link: '/components/cluster' },
          ]
        },
        {
          text: 'Navigation',
          items: [
            { text: 'App Bar', link: '/components/app-bar' },
            { text: 'Bottom Nav', link: '/components/bottom-nav' },
            { text: 'Tabs', link: '/components/tabs' },
            { text: 'Breadcrumb', link: '/components/breadcrumb' },
            { text: 'Pagination', link: '/components/pagination' },
          ]
        },
        {
          text: 'Overlays',
          items: [
            { text: 'Modal', link: '/components/modal' },
            { text: 'Sheet', link: '/components/sheet' },
            { text: 'Drawer', link: '/components/drawer' },
            { text: 'Popover', link: '/components/popover' },
            { text: 'Dropdown', link: '/components/dropdown' },
          ]
        },
        {
          text: 'Feedback',
          items: [
            { text: 'Alert', link: '/components/alert' },
            { text: 'Toast', link: '/components/toast' },
            { text: 'Spinner', link: '/components/spinner' },
            { text: 'Progress', link: '/components/progress' },
            { text: 'Skeleton', link: '/components/skeleton' },
            { text: 'Empty State', link: '/components/empty-state' },
          ]
        },
        {
          text: 'Forms',
          items: [
            { text: 'Input', link: '/components/input' },
            { text: 'Textarea', link: '/components/textarea' },
            { text: 'Select', link: '/components/select' },
            { text: 'Checkbox', link: '/components/checkbox' },
            { text: 'Radio', link: '/components/radio' },
            { text: 'Switch', link: '/components/switch' },
            { text: 'Segmented', link: '/components/segmented' },
          ]
        },
        {
          text: 'Data Display',
          items: [
            { text: 'Avatar', link: '/components/avatar' },
            { text: 'Badge', link: '/components/badge' },
            { text: 'List', link: '/components/list' },
            { text: 'Meta', link: '/components/meta' },
            { text: 'Rating', link: '/components/rating' },
            { text: 'Divider', link: '/components/divider' },
          ]
        },
        {
          text: 'Media',
          items: [
            { text: 'Media', link: '/components/media' },
            { text: 'Gallery', link: '/components/gallery' },
            { text: 'Video Player', link: '/components/video-player' },
            { text: 'Audio Player', link: '/components/audio-player' },
          ]
        },
        {
          text: 'Files',
          items: [
            { text: 'File Input', link: '/components/file-input' },
            { text: 'Dropzone', link: '/components/dropzone' },
          ]
        },
        {
          text: 'Rich UI',
          items: [
            { text: 'Chip', link: '/components/chip' },
            { text: 'FAB', link: '/components/fab' },
            { text: 'Comment', link: '/components/comment' },
            { text: 'Keyboard', link: '/components/keyboard' },
            { text: 'Toolbar', link: '/components/toolbar' },
          ]
        },
      ],
      '/utilities/': [
        {
          text: 'Utilities',
          items: [
            { text: 'Display', link: '/utilities/display' },
            { text: 'Flex', link: '/utilities/flex' },
            { text: 'Spacing', link: '/utilities/spacing' },
            { text: 'Text', link: '/utilities/text' },
          ]
        }
      ],
      '/integrations/': [
        {
          text: 'Integrations',
          items: [
            { text: 'Bootstrap Icons', link: '/integrations/bootstrap-icons' },
            { text: 'Swiper', link: '/integrations/swiper' },
            { text: 'GLightbox', link: '/integrations/glightbox' },
          ]
        }
      ],
    },

    socialLinks: [
      { icon: 'github', link: 'https://github.com/anomalyco/orp-ui' }
    ],

    search: {
      provider: 'local'
    },

    editLink: {
      pattern: 'https://github.com/anomalyco/orp-ui/edit/main/docs/:path',
      text: 'Edit this page on GitHub'
    },

    footer: {
      message: 'Released under the MIT License.',
      copyright: 'Copyright © 2024-present ORP UI'
    }
  },

  vite: {
    css: {
      preprocessorOptions: {
        less: {
          javascriptEnabled: true
        }
      }
    }
  }
})
