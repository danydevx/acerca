<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Buttons</h3>
      <div class="mb-4">
        <h4 class="subtitle is-6">Colors</h4>
        <div class="buttons">
          <button class="button">Default</button>
          <button class="button is-primary">Primary</button>
          <button class="button is-link">Link</button>
          <button class="button is-info">Info</button>
          <button class="button is-success">Success</button>
          <button class="button is-warning">Warning</button>
          <button class="button is-danger">Danger</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Light Colors</h4>
        <div class="buttons">
          <button class="button is-primary is-light">Primary Light</button>
          <button class="button is-link is-light">Link Light</button>
          <button class="button is-info is-light">Info Light</button>
          <button class="button is-success is-light">Success Light</button>
          <button class="button is-warning is-light">Warning Light</button>
          <button class="button is-danger is-light">Danger Light</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Outlined</h4>
        <div class="buttons">
          <button class="button is-primary is-outlined">Primary</button>
          <button class="button is-link is-outlined">Link</button>
          <button class="button is-info is-outlined">Info</button>
          <button class="button is-success is-outlined">Success</button>
          <button class="button is-warning is-outlined">Warning</button>
          <button class="button is-danger is-outlined">Danger</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Inverted</h4>
        <div class="buttons" style="background: #363636; padding: 1rem; border-radius: 8px;">
          <button class="button is-primary is-inverted">Primary</button>
          <button class="button is-link is-inverted">Link</button>
          <button class="button is-info is-inverted">Info</button>
          <button class="button is-success is-inverted">Success</button>
          <button class="button is-warning is-inverted">Warning</button>
          <button class="button is-danger is-inverted">Danger</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Sizes</h4>
        <div class="buttons">
          <button class="button is-small">Small</button>
          <button class="button">Default</button>
          <button class="button is-normal">Normal</button>
          <button class="button is-medium">Medium</button>
          <button class="button is-large">Large</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Loading State</h4>
        <div class="buttons">
          <button class="button is-primary is-loading">Loading</button>
          <button class="button is-info is-loading">Loading</button>
          <button class="button is-success is-loading">Loading</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Disabled</h4>
        <div class="buttons">
          <button class="button" disabled>Default</button>
          <button class="button is-primary" disabled>Primary</button>
          <button class="button is-link" disabled>Link</button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">With Icons</h4>
        <div class="buttons">
          <button class="button is-primary">
            <span class="icon"><i class="bi bi-heart-fill"></i></span>
            <span>Like</span>
          </button>
          <button class="button is-info">
            <span class="icon"><i class="bi bi-share"></i></span>
            <span>Share</span>
          </button>
          <button class="button is-success">
            <span class="icon"><i class="bi bi-check-lg"></i></span>
            <span>Confirm</span>
          </button>
          <button class="button is-danger is-outlined">
            <span class="icon"><i class="bi bi-trash"></i></span>
            <span>Delete</span>
          </button>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Icon Buttons</h4>
        <div class="buttons">
          <button class="button is-primary is-rounded">
            <span class="icon"><i class="bi bi-heart"></i></span>
          </button>
          <button class="button is-info is-rounded">
            <span class="icon"><i class="bi bi-share"></i></span>
          </button>
          <button class="button is-success is-rounded">
            <span class="icon"><i class="bi bi-bookmark"></i></span>
          </button>
          <button class="button is-warning is-rounded">
            <span class="icon"><i class="bi bi-star"></i></span>
          </button>
          <button class="button is-danger is-rounded">
            <span class="icon"><i class="bi bi-trash"></i></span>
          </button>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Typography</h3>
      <div class="mb-4">
        <h4 class="subtitle is-6">Titles</h4>
        <h1 class="title is-1">Title 1</h1>
        <h1 class="title is-2">Title 2</h1>
        <h1 class="title is-3">Title 3</h1>
        <h1 class="title is-4">Title 4</h1>
        <h1 class="title is-5">Title 5</h1>
        <h1 class="title is-6">Title 6</h1>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Subtitles</h4>
        <h3 class="subtitle is-3">Subtitle 3</h3>
        <h3 class="subtitle is-4">Subtitle 4</h3>
        <h3 class="subtitle is-5">Subtitle 5</h3>
        <h3 class="subtitle is-6">Subtitle 6</h3>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Text Colors</h4>
        <p class="has-text-black">Black text</p>
        <p class="has-text-dark">Dark text</p>
        <p class="has-text-light">Light text (on dark)</p>
        <p class="has-text-white">White text</p>
        <p class="has-text-primary">Primary text</p>
        <p class="has-text-link">Link text</p>
        <p class="has-text-info">Info text</p>
        <p class="has-text-success">Success text</p>
        <p class="has-text-warning">Warning text</p>
        <p class="has-text-danger">Danger text</p>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Text Sizes</h4>
        <p class="is-size-1">Size 1</p>
        <p class="is-size-2">Size 2</p>
        <p class="is-size-3">Size 3</p>
        <p class="is-size-4">Size 4</p>
        <p class="is-size-5">Size 5</p>
        <p class="is-size-6">Size 6</p>
        <p class="is-size-7">Size 7</p>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Weights</h4>
        <p class="has-text-weight-light">Light weight</p>
        <p class="has-text-weight-normal">Normal weight</p>
        <p class="has-text-weight-medium">Medium weight</p>
        <p class="has-text-weight-semibold">Semi-bold weight</p>
        <p class="has-text-weight-bold">Bold weight</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Colors</h3>
      <div class="mb-4">
        <h4 class="subtitle is-6">Background Colors</h4>
        <div class="columns is-multiline">
          <div class="column is-2">
            <div class="has-background-black has-text-white p-3 has-text-centered">.has-background-black</div>
          </div>
          <div class="column is-2">
            <div class="has-background-dark has-text-white p-3 has-text-centered">.has-background-dark</div>
          </div>
          <div class="column is-2">
            <div class="has-background-light p-3 has-text-centered">.has-background-light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-white p-3 has-text-centered">.has-background-white</div>
          </div>
          <div class="column is-2">
            <div class="has-background-primary has-text-white p-3 has-text-centered">Primary</div>
          </div>
          <div class="column is-2">
            <div class="has-background-link has-text-white p-3 has-text-centered">Link</div>
          </div>
          <div class="column is-2">
            <div class="has-background-info has-text-white p-3 has-text-centered">Info</div>
          </div>
          <div class="column is-2">
            <div class="has-background-success has-text-white p-3 has-text-centered">Success</div>
          </div>
          <div class="column is-2">
            <div class="has-background-warning p-3 has-text-centered">Warning</div>
          </div>
          <div class="column is-2">
            <div class="has-background-danger has-text-white p-3 has-text-centered">Danger</div>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Light Background Colors</h4>
        <div class="columns is-multiline">
          <div class="column is-2">
            <div class="has-background-primary-light p-3 has-text-centered">Primary Light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-link-light p-3 has-text-centered">Link Light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-info-light p-3 has-text-centered">Info Light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-success-light p-3 has-text-centered">Success Light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-warning-light p-3 has-text-centered">Warning Light</div>
          </div>
          <div class="column is-2">
            <div class="has-background-danger-light p-3 has-text-centered">Danger Light</div>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Box Component</h3>
      <div class="columns">
        <div class="column is-4">
          <div class="box">
            <h5 class="title is-5">Simple Box</h5>
            <p>This is a basic box component with some content inside.</p>
          </div>
        </div>
        <div class="column is-4">
          <div class="box has-background-primary has-text-white">
            <h5 class="title is-5">Primary Box</h5>
            <p>A box with primary background color.</p>
          </div>
        </div>
        <div class="column is-4">
          <div class="box has-background-info-light">
            <h5 class="title is-5">Info Box</h5>
            <p>A box with info light background.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Tags</h3>
      <div class="mb-4">
        <h4 class="subtitle is-6">Basic Tags</h4>
        <div class="tags">
          <span class="tag">Default</span>
          <span class="tag is-black">Black</span>
          <span class="tag is-dark">Dark</span>
          <span class="tag is-light">Light</span>
          <span class="tag is-white">White</span>
          <span class="tag is-primary">Primary</span>
          <span class="tag is-link">Link</span>
          <span class="tag is-info">Info</span>
          <span class="tag is-success">Success</span>
          <span class="tag is-warning">Warning</span>
          <span class="tag is-danger">Danger</span>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Tag Sizes</h4>
        <div class="tags">
          <span class="tag is-primary is-small">Small</span>
          <span class="tag is-info is-medium">Medium</span>
          <span class="tag is-success is-large">Large</span>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Rounded Tags</h4>
        <div class="tags">
          <span class="tag is-rounded">Rounded Default</span>
          <span class="tag is-primary is-rounded">Rounded Primary</span>
          <span class="tag is-danger is-rounded is-medium">
            <span class="icon"><i class="bi bi-x"></i></span>
            <span>Rounded with Icon</span>
          </span>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Tags with Delete</h4>
        <div class="tags">
          <span class="tag is-success">
            Success
            <button class="delete is-small"></button>
          </span>
          <span class="tag is-warning">
            Warning
            <button class="delete is-small"></button>
          </span>
          <span class="tag is-danger is-medium">
            Danger
            <button class="delete"></button>
          </span>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Badges</h3>
      <div class="mb-4">
        <h4 class="subtitle is-6">Inline Badges</h4>
        <p>Notifications <span class="tag is-primary is-rounded">5</span> unread messages.</p>
        <p>Cart items <span class="tag is-warning is-rounded">3</span></p>
      </div>

      <div class="mb-4">
        <h4 class="subtitle is-6">Badge Sizes</h4>
        <div class="buttons">
          <span class="button is-static">
            Notifications
            <span class="tag is-primary is-small ml-2">2</span>
          </span>
          <span class="button is-static">
            Messages
            <span class="tag is-info ml-2">12</span>
          </span>
          <span class="button is-static">
            Alerts
            <span class="tag is-danger is-medium ml-2">99+</span>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.title.is-1, .title.is-2, .title.is-3, .title.is-4, .title.is-5, .title.is-6 {
  margin-bottom: 0.5rem;
}
</style>
