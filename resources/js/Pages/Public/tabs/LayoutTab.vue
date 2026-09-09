<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Container</h3>
      <div class="has-background-primary-light p-4 mb-4">
        <p class="is-size-6">Standard container - max-width with horizontal padding</p>
      </div>
      <div class="has-background-info-light p-4 mb-4">
        <p class="is-size-6">Container with <strong>is-widescreen</strong> - wider on large screens</p>
      </div>
      <div class="has-background-success-light p-4">
        <p class="is-size-6">Container with <strong>is-fullhd</strong> - full HD width</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Hero</h3>
      <div class="hero is-primary">
        <div class="hero-body">
          <div class="container has-text-centered">
            <p class="title is-2">Primary Hero</p>
            <p class="subtitle">With body content</p>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="hero is-info is-bold">
        <div class="hero-body">
          <div class="container">
            <p class="title is-3">Bold Info Hero</p>
            <p class="subtitle">With gradient background</p>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="hero is-success is-medium">
        <div class="hero-body">
          <div class="container has-text-left">
            <p class="title">Medium Hero - Left Aligned</p>
            <p class="subtitle">More vertical padding</p>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="hero is-warning is-large">
        <div class="hero-body">
          <div class="container has-text-right">
            <p class="title is-2">Large Hero</p>
            <p class="subtitle">Right aligned content</p>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="hero is-danger is-bold is-halfheight">
        <div class="hero-body">
          <div class="container">
            <p class="title">Half Height Hero</p>
            <p class="subtitle">With subtitle text</p>
          </div>
        </div>
        <div class="hero-footer">
          <p class="has-text-centered has-text-white">Hero Footer</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Section</h3>
      <div class="section has-background-light">
        <p class="title is-5">Standard Section</p>
        <p>A light themed section</p>
      </div>
      <div class="section has-background-dark has-text-white">
        <p class="title is-5 has-text-white">Dark Section</p>
        <p>Dark themed section</p>
      </div>
      <div class="section has-background-primary has-text-white">
        <p class="title is-5 has-text-white">Primary Section</p>
        <p>Primary themed section</p>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Footer</h3>
      <footer class="footer has-background-dark has-text-white">
        <div class="content has-text-centered">
          <p>
            <strong class="has-text-white">Bulma</strong> Footer Component
          </p>
          <p>© 2024 Your Company. All rights reserved.</p>
          <div class="buttons is-centered">
            <button class="button is-small is-light">About</button>
            <button class="button is-small is-light">Contact</button>
            <button class="button is-small is-light">Terms</button>
            <button class="button is-small is-light">Privacy</button>
          </div>
        </div>
      </footer>
    </div>

    <div class="box">
      <h3 class="title is-4">Level</h3>
      <nav class="level">
        <div class="level-left">
          <div class="level-item">
            <p class="subtitle is-5"><strong>123</strong> Posts</p>
          </div>
          <div class="level-item">
            <div class="field has-addons">
              <p class="control">
                <input class="input" type="text" placeholder="Search...">
              </p>
              <p class="control">
                <button class="button is-info">Search</button>
              </p>
            </div>
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <button class="button is-primary">New Post</button>
          </div>
        </div>
      </nav>
    </div>

    <div class="box">
      <h3 class="title is-4">Level - Mobile</h3>
      <nav class="level is-mobile">
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Posts</p>
            <p class="title is-4">123</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Followers</p>
            <p class="title is-4">456</p>
          </div>
        </div>
        <div class="level-item has-text-centered">
          <div>
            <p class="heading">Following</p>
            <p class="title is-4">789</p>
          </div>
        </div>
      </nav>
    </div>

    <div class="box">
      <h3 class="title is-4">Media Object</h3>
      <article class="media">
        <figure class="media-left">
          <p class="image is-64x64">
            <img class="is-rounded" src="https://picsum.photos/64/64?random=1">
          </p>
        </figure>
        <div class="media-content">
          <div class="content">
            <p>
              <strong>John Doe</strong> <small>@johndoe</small> <small>31m</small>
              <br>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna risus, sed mollis lacus commodo id.
            </p>
          </div>
          <nav class="level is-mobile">
            <div class="level-left">
              <a class="level-item">
                <span class="icon is-small"><i class="bi bi-chat"></i></span>
              </a>
              <a class="level-item">
                <span class="icon is-small"><i class="bi bi-arrow-repeat"></i></span>
              </a>
              <a class="level-item">
                <span class="icon is-small"><i class="bi bi-heart"></i></span>
              </a>
            </div>
          </nav>
        </div>
        <div class="media-right">
          <button class="delete"></button>
        </div>
      </article>
    </div>

    <div class="box">
      <h3 class="title is-4">Columns System</h3>
      <div class="columns">
        <div class="column has-background-primary has-text-white has-text-centered p-3">First Column</div>
        <div class="column has-background-info has-text-white has-text-centered p-3">Second Column</div>
        <div class="column has-background-success has-text-white has-text-centered p-3">Third Column</div>
      </div>

      <div class="columns is-mobile mt-4">
        <div class="column has-background-warning has-text-centered p-3">is-12 (Mobile)</div>
      </div>
      <div class="columns is-mobile">
        <div class="column has-background-warning has-text-centered p-3">is-6</div>
        <div class="column has-background-warning has-text-centered p-3">is-6</div>
      </div>
      <div class="columns is-mobile">
        <div class="column has-background-warning has-text-centered p-3">is-4</div>
        <div class="column has-background-warning has-text-centered p-3">is-4</div>
        <div class="column has-background-warning has-text-centered p-3">is-4</div>
      </div>
      <div class="columns is-mobile">
        <div class="column has-background-warning has-text-centered p-3">is-3</div>
        <div class="column has-background-warning has-text-centered p-3">is-3</div>
        <div class="column has-background-warning has-text-centered p-3">is-3</div>
        <div class="column has-background-warning has-text-centered p-3">is-3</div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Columns - Responsive</h3>
      <div class="columns is-multiline">
        <div class="column is-12-mobile is-4-tablet is-3-desktop has-background-primary has-text-white has-text-centered p-3">
          Column 1
        </div>
        <div class="column is-6-mobile is-4-tablet is-3-desktop has-background-info has-text-white has-text-centered p-3">
          Column 2
        </div>
        <div class="column is-6-mobile is-4-tablet is-3-desktop has-background-success has-text-white has-text-centered p-3">
          Column 3
        </div>
        <div class="column is-12-mobile is-4-tablet is-3-desktop has-background-danger has-text-white has-text-centered p-3">
          Column 4
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

.hero {
  border-radius: 8px;
  overflow: hidden;
}

.mt-4 {
  margin-top: 1.5rem;
}

.footer {
  padding: 3rem 1.5rem;
  border-radius: 8px;
}
</style>
