<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Content Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiContentCard
            title="Article Title"
            description="A brief description of the article content."
            category="Technology"
            date="Dec 15, 2024"
            image="https://picsum.photos/400/200?random=1"
          />
        </div>
        <div class="column is-4">
          <UiContentCard
            title="Blog Post"
            description="Another interesting article with more content."
            category="Lifestyle"
            date="Dec 14, 2024"
            image="https://picsum.photos/400/200?random=2"
            :featured="true"
          />
        </div>
        <div class="column is-4">
          <UiContentCard
            title="News Update"
            description="Latest news in the industry."
            category="News"
            date="Dec 13, 2024"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Media Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiMediaCard
            title="Beach Vacation"
            location="Maldives"
            image="https://picsum.photos/400/300?random=10"
            :rating="4.5"
            reviews="128"
          />
        </div>
        <div class="column is-4">
          <UiMediaCard
            title="Mountain Adventure"
            location="Switzerland"
            image="https://picsum.photos/400/300?random=11"
            :rating="5"
            reviews="256"
            :featured="true"
          />
        </div>
        <div class="column is-4">
          <UiMediaCard
            title="City Break"
            location="Paris, France"
            image="https://picsum.photos/400/300?random=12"
            :rating="4"
            reviews="89"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Catalog Card</h3>
      <div class="columns is-multiline">
        <div class="column is-3">
          <UiCatalogCard
            title="Modern Sofa"
            price="$599"
            category="Furniture"
            image="https://picsum.photos/300/300?random=20"
          />
        </div>
        <div class="column is-3">
          <UiCatalogCard
            title="Designer Lamp"
            price="$89"
            category="Lighting"
            image="https://picsum.photos/300/300?random=21"
            :new="true"
          />
        </div>
        <div class="column is-3">
          <UiCatalogCard
            title="Wooden Table"
            price="$349"
            category="Furniture"
            image="https://picsum.photos/300/300?random=22"
            :sale="true"
            originalPrice="$449"
          />
        </div>
        <div class="column is-3">
          <UiCatalogCard
            title="Office Chair"
            price="$199"
            category="Furniture"
            image="https://picsum.photos/300/300?random=23"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Pricing Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiPricingCard
            title="Basic"
            price="$9"
            period="/month"
            :features="['Feature 1', 'Feature 2', 'Feature 3']"
            cta="Get Started"
          />
        </div>
        <div class="column is-4">
          <UiPricingCard
            title="Pro"
            price="$29"
            period="/month"
            :features="['All Basic features', 'Priority support', 'Advanced analytics', 'Custom integrations']"
            cta="Get Started"
            :popular="true"
          />
        </div>
        <div class="column is-4">
          <UiPricingCard
            title="Enterprise"
            price="$99"
            period="/month"
            :features="['All Pro features', 'Dedicated support', 'Unlimited users', 'Custom solutions']"
            cta="Contact Sales"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Pricing Card - Variants</h3>
      <div class="columns">
        <div class="column is-4">
          <UiPricingCard
            title="Elevated"
            price="$19"
            period="/month"
            :features="['Feature A', 'Feature B']"
            variant="elevated"
          />
        </div>
        <div class="column is-4">
          <UiPricingCard
            title="Borderless"
            price="$29"
            period="/month"
            :features="['Feature A', 'Feature B', 'Feature C']"
            variant="borderless"
          />
        </div>
        <div class="column is-4">
          <UiPricingCard
            title="Gradient"
            price="$39"
            period="/month"
            :features="['Feature A', 'Feature B', 'Feature C', 'Feature D']"
            variant="gradient"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Profile Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiProfileCard
            name="John Doe"
            role="Software Engineer"
            avatar="https://picsum.photos/150/150?random=30"
            :stats="{ posts: 120, followers: 450, following: 230 }"
          />
        </div>
        <div class="column is-4">
          <UiProfileCard
            name="Jane Smith"
            role="Product Designer"
            avatar="https://picsum.photos/150/150?random=31"
            :stats="{ posts: 89, followers: 1200, following: 150 }"
            :verified="true"
          />
        </div>
        <div class="column is-4">
          <UiProfileCard
            name="Bob Wilson"
            role="CTO"
            avatar="https://picsum.photos/150/150?random=32"
            :stats="{ posts: 45, followers: 890, following: 120 }"
            bio="Passionate about building great products."
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Contact Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiContactCard
            name="Acme Corp"
            email="contact@acme.com"
            phone="+1 234 567 890"
            address="123 Main St, City"
          />
        </div>
        <div class="column is-4">
          <UiContactCard
            name="Support Team"
            email="support@example.com"
            phone="+1 234 567 891"
            address="456 Tech Park, Valley"
            :social="true"
          />
        </div>
        <div class="column is-4">
          <UiContactCard
            name="John Doe"
            email="john@personal.com"
            phone="+1 234 567 892"
            :social="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Stat Card</h3>
      <div class="columns">
        <div class="column is-3">
          <UiStatCard
            title="Total Users"
            value="12,345"
            icon="users"
            trend="+12%"
            trendDirection="up"
          />
        </div>
        <div class="column is-3">
          <UiStatCard
            title="Revenue"
            value="$45,678"
            icon="dollar"
            trend="+8%"
            trendDirection="up"
          />
        </div>
        <div class="column is-3">
          <UiStatCard
            title="Bounce Rate"
            value="24%"
            icon="chart"
            trend="-3%"
            trendDirection="down"
          />
        </div>
        <div class="column is-3">
          <UiStatCard
            title="Active Now"
            value="1,234"
            icon="activity"
            :isLive="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Interactive Card</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiInteractiveCard
            title="Hover Me"
            description="This card has interactive hover states."
            icon="info"
          />
        </div>
        <div class="column is-4">
          <UiInteractiveCard
            title="Click Action"
            description="You can click this card for more details."
            icon="search"
            @click="handleCardClick"
          />
        </div>
        <div class="column is-4">
          <UiInteractiveCard
            title="Selectable"
            description="This card can be selected."
            icon="check"
            :selectable="true"
            v-model="selectedCard"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiContentCard from '@/Components/Ui/content/ContentCard.vue'
import UiMediaCard from '@/Components/Ui/MediaCard.vue'
import UiCatalogCard from '@/Components/Ui/catalog/CatalogCard.vue'
import UiPricingCard from '@/Components/Ui/pricing/PricingCard.vue'
import UiProfileCard from '@/Components/Ui/profile/ProfileCard.vue'
import UiContactCard from '@/Components/Ui/contact/ContactCard.vue'
import UiStatCard from '@/Components/Ui/content/StatCard.vue'
import UiInteractiveCard from '@/Components/Ui/content/InteractiveCard.vue'

const selectedCard = ref(false)

const handleCardClick = () => {
  alert('Card clicked!')
}
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}
</style>
