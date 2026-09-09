<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Product Card - Variants</h3>
      <div class="columns is-multiline">
        <div class="column is-3">
          <UiProductCard
            :item="{ name: 'Basic Product', price: 29.99, image: 'https://picsum.photos/300/300?random=1' }"
          />
        </div>
        <div class="column is-3">
          <UiProductCard
            :item="{ name: 'With Description', price: 49.99, image: 'https://picsum.photos/300/300?random=2', description: 'This product has a detailed description that explains its features.' }"
            :show-description="true"
          />
        </div>
        <div class="column is-3">
          <UiProductCard
            :item="{ name: 'With Discount', price: 39.99, compare_at_price: 59.99, image: 'https://picsum.photos/300/300?random=3' }"
            :show-compare-price="true"
          />
        </div>
        <div class="column is-3">
          <UiProductCard
            :item="{ name: 'Out of Stock', price: 29.99, image: 'https://picsum.photos/300/300?random=4', quantity: 0 }"
            :show-stock="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Product Card - CTA Variants</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiProductCard
            :item="{ name: 'Default CTA', price: 29.99, image: 'https://picsum.photos/300/300?random=10' }"
            cta-label="Add to Cart"
          />
        </div>
        <div class="column is-4">
          <UiProductCard
            :item="{ name: 'Arrow CTA', price: 39.99, image: 'https://picsum.photos/300/300?random=11' }"
            cta-variant="arrow"
            cta-label="View Details"
          />
        </div>
        <div class="column is-4">
          <UiProductCard
            :item="{ name: 'Icon CTA', price: 49.99, image: 'https://picsum.photos/300/300?random=12' }"
            cta-variant="icon"
            cta-label="Add"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Product Card - Horizontal</h3>
      <div class="columns">
        <div class="column is-6">
          <UiProductCard
            :item="{ name: 'Horizontal Product', price: 29.99, image: 'https://picsum.photos/300/300?random=20' }"
            :horizontal="true"
            cta-label="Add to Cart"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Service Card - Variants</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiServiceCard
            :item="{ name: 'Basic Service', price: 50, duration_minutes: 30, description: 'A basic service description' }"
          />
        </div>
        <div class="column is-4">
          <UiServiceCard
            :item="{ name: 'Premium Service', price: 100, duration_minutes: 60, description: 'A premium service with more features' }"
            :featured="true"
          />
        </div>
        <div class="column is-4">
          <UiServiceCard
            :item="{ name: 'With Deposit', price: 75, duration_minutes: 45, description: 'Service requiring a deposit', deposit_required: 25 }"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Service List Item</h3>
      <div class="mb-4">
        <UiServiceListItem
          :item="{ name: 'Basic Haircut', price: 25, duration_minutes: 30 }"
        />
      </div>
      <div class="mb-4">
        <UiServiceListItem
          :item="{ name: 'Haircut with Wash', price: 35, duration_minutes: 45, image: 'https://picsum.photos/100/100?random=30' }"
          :has-image="true"
        />
      </div>
      <div class="mb-4">
        <UiServiceListItem
          :item="{ name: 'Premium Package', price: 85, duration_minutes: 90, image: 'https://picsum.photos/100/100?random=31', deposit_required: 30 }"
          :has-image="true"
        />
      </div>
      <div>
        <UiServiceListItem
          :item="{ name: 'No Image Service', price: 45, duration_minutes: 60 }"
          :has-image="false"
        />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Video Playlist</h3>
      <UiVideoPlaylist
        title="Tutorial Playlist"
        :items="videoPlaylistItems"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Calendar - MiniCalendar</h3>
      <div class="columns">
        <div class="column is-4">
          <UiMiniCalendar
            v-model="selectedDate"
            :events="calendarEvents"
          />
        </div>
        <div class="column is-4">
          <UiMiniCalendar
            v-model="selectedDate"
            :events="calendarEvents"
            :compact="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Availability</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiAvailabilityStatus
            :is-open="true"
            :closes-at="'20:00'"
            :show-time="true"
          />
        </div>
        <div class="column is-4">
          <UiAvailabilityStatus
            :is-open="false"
            :opens-at="'09:00'"
            :show-time="true"
          />
        </div>
        <div class="column is-4">
          <UiOpeningHours
            :schedule="businessSchedule"
            :highlight-today="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Social Links</h3>
      <div class="mb-4">
        <UiSocialLinks :items="socialItems" />
      </div>
      <div class="mb-4">
        <UiSocialLinks :items="socialItems" :icon-only="true" />
      </div>
      <div>
        <UiSocialLinks :items="socialItems" :horizontal="true" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Contact Actions</h3>
      <div class="mb-4">
        <UiContactList :items="contactItems" />
      </div>
      <div class="mb-4">
        <UiContactList :items="contactItems" :icon-only="true" />
      </div>
      <div class="mb-4">
        <UiContactAction
          type="whatsapp"
          value="+52 55 1234 5678"
          label="WhatsApp"
        />
      </div>
      <div>
        <UiContactAction
          type="phone"
          value="+52 55 1234 5678"
          label="Llamar"
          :primary="true"
        />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Business Status</h3>
      <div class="mb-4">
        <UiBusinessStatus
          :is-open="true"
          :closes-at="'20:00'"
          :schedule="businessSchedule"
          :show-schedule="true"
        />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Reviews / Rating</h3>
      <div class="mb-4">
        <UiRating :value="4.8" :count="127" :show-value="true" />
      </div>
      <div class="mb-4">
        <UiRating :value="4.5" :count="89" />
      </div>
      <UiReviewCard
        :author="'María García'"
        :rating="5"
        title="Excelente servicio"
        text="El mejor servicio que he recibido. El personal es muy atento y profesional."
        date="2026-08-15"
        source="Google"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Event Date</h3>
      <div class="columns is-multiline">
        <div class="column is-2">
          <UiEventDate date="2026-09-15" />
        </div>
        <div class="column is-2">
          <UiEventDate date="2026-12-25" :compact="true" />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Location Card</h3>
      <div class="columns">
        <div class="column is-4">
          <UiLocationCard
            name="Sucursal Centro"
            address="Av. Principal 123, Col. Centro, CDMX"
            phone="+52 55 1234 5678"
            :is-open="true"
            :closes-at="'20:00'"
            image="https://picsum.photos/400/225?random=50"
            distance="0.5 km"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Team Member</h3>
      <div class="columns is-multiline">
        <div class="column is-3">
          <UiTeamMember
            name="Juan Pérez"
            role="Director General"
            bio="Más de 15 años de experiencia en el industry."
            image="https://picsum.photos/200/200?random=60"
            :social="[{ network: 'linkedin', url: '#' }, { network: 'email', url: '#' }]"
          />
        </div>
        <div class="column is-3">
          <UiTeamMember
            name="Ana López"
            role="Diseñadora"
            :social="[{ network: 'instagram', url: '#' }]"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Team Grid</h3>
      <UiTeamGrid :members="teamMembers" />
    </div>

    <div class="box">
      <h3 class="title is-4">Time Slot</h3>
      <div class="mb-4">
        <UiTimeSlot :slots="timeSlots" label="Mañana" @select="selectedTime = $event.time" />
      </div>
      <p v-if="selectedTime">Seleccionado: {{ selectedTime }}</p>
    </div>

    <div class="box">
      <h3 class="title is-4">Booking Progress</h3>
      <UiBookingProgress
        :steps="['Fecha', 'Hora', 'Servicio', 'Confirmar']"
        :current-step="currentStep"
        @step="currentStep = $event"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Booking Summary</h3>
      <UiBookingSummary
        :date="new Date()"
        time="10:00 AM"
        service="Corte de cabello"
        :guests="2"
        price="$350"
      />
    </div>

    <div class="box">
      <h3 class="title is-4">Review Summary</h3>
      <div class="columns">
        <div class="column is-4">
          <UiReviewSummary :average="4.8" :total="127" />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Event Components</h3>
      <div class="mb-4">
        <UiEventTime :start="'2026-09-15T10:00'" :end="'2026-09-15T12:00'" />
      </div>
      <div class="mb-4">
        <UiEventLocation
          name="Centro de Convenciones"
          address="Av. Principal 100, CDMX"
        />
      </div>
      <div class="mb-4">
        <UiEventCard
          title="Conferencia Anual 2026"
          subtitle="Tecnología y Negocios"
          date="2026-10-15"
          :time="{ start: '09:00', end: '18:00' }"
          :location="{ name: 'Centro de Convenciones', address: 'Av. Principal 100' }"
          image="https://picsum.photos/600/340?random=100"
          price="$1,500"
          description="Únete a nosotros para la conferencia más importante del año."
        />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Address Block & Directions</h3>
      <div class="mb-4">
        <UiAddressBlock
          label="Oficina Principal"
          address="Av. Principal 123, Col. Centro, CDMX, CP 06000"
        />
      </div>
      <UiDirectionsButton address="Av. Principal 123, CDMX" />
    </div>

    <div class="box">
      <h3 class="title is-4">Pricing Components</h3>
      <div class="mb-4">
        <UiPrice value="299.99" />
      </div>
      <div class="mb-4">
        <UiOldPrice value="499.99" /> - <UiDiscount value="40" />
      </div>
      <div class="mb-4">
        <UiPrice value="299.99" size="lg" /> <UiOldPrice value="499.99" />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Property Components</h3>
      <div class="mb-4">
        <h4 class="title is-5">Property Status</h4>
        <div class="mb-3">
          <UiPropertyStatus status="for_sale" /> -
          <UiPropertyStatus status="for_rent" /> -
          <UiPropertyStatus status="sold" /> -
          <UiPropertyStatus status="new" />
        </div>
        <UiPropertyFeatures :beds="3" :baths="2" :area="150" />
      </div>
      <div class="columns is-multiline">
        <div class="column is-4">
          <UiPropertyCard
            :property="{}"
            title="Casa moderna en el centro"
            address="Av. Principal 456, Col. Centro, CDMX"
            price="2500000"
            price-type="sale"
            status="for_sale"
            badge="Nuevo"
            :beds="3"
            :baths="2"
            :area="150"
            image="https://picsum.photos/400/250?random=101"
            agent="Juan Inmobiliario"
          />
        </div>
        <div class="column is-4">
          <UiPropertyCard
            :property="{}"
            title="Departamento con vista al parque"
            address="Calle Las Flores 789, Col. Jardín, GDL"
            price="15000"
            price-type="rent"
            status="for_rent"
            :beds="2"
            :baths="1"
            :area="80"
            image="https://picsum.photos/400/250?random=102"
          />
        </div>
        <div class="column is-4">
          <UiPropertyCard
            :property="{}"
            title="Casa con jardín grande"
            address="Av. Los Arboles 321, Col. Verde, MTY"
            price="3800000"
            price-type="sale"
            status="reduced"
            badge="Reducido"
            :beds="4"
            :baths="3"
            :area="250"
            image="https://picsum.photos/400/250?random=103"
            :horizontal="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">E-commerce Components</h3>
      <div class="mb-4">
        <h4 class="title is-5">Product Stock</h4>
        <div class="mb-3">
          <UiProductStock :quantity="25" /> <br><br>
          <UiProductStock :quantity="3" /> <br><br>
          <UiProductStock :quantity="0" /> <br><br>
          <UiProductStock :quantity="null" />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Product Image</h4>
        <div class="columns is-vcentered">
          <div class="column is-3">
            <UiProductImage
              src="https://picsum.photos/400/300?random=201"
              alt="Product image"
              badge="Nuevo"
            />
          </div>
          <div class="column is-3">
            <UiProductImage
              src=""
              alt="No image"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Product Gallery</h4>
        <div class="column is-6">
          <UiProductGallery
            :images="galleryImages"
            @preview="currentImage = $event"
          />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Product Meta</h4>
        <UiProductMeta
          sku="PRD-12345"
          category="Electrónicos"
          brand="TechBrand"
          :tags="['Nuevo', 'Popular', 'Oferta']"
        />
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Product Variant</h4>
        <UiProductVariant
          v-model="selectedColor"
          label="Color"
          :options="colorOptions"
        />
        <br>
        <UiProductVariant
          v-model="selectedSize"
          label="Talla"
          :options="sizeOptions"
        />
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Action Components</h3>
      <div class="mb-4">
        <h4 class="title is-5">Share, Copy & Favorite</h4>
        <div class="is-flex is-flex-wrap-wrap gap-3">
          <UiShareButton
            title="Mi MiniWeb"
            text="Mira mi sitio web"
            url="https://ejemplo.com"
          />
          <UiCopyButton text="https://ejemplo.com/miniweb" />
          <UiFavoriteButton v-model="favorite" />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Quantity Selector</h4>
        <UiQuantitySelector v-model="quantity" :min="1" :max="20" />
        <span class="ml-3">Cantidad: {{ quantity }}</span>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Content Components</h3>
      <div class="mb-4">
        <h4 class="title is-5">Feature Cards</h4>
        <div class="columns is-multiline">
          <div class="column is-3">
            <UiFeatureCard
              icon="bi bi-truck"
              title="Envío Gratis"
              description="En pedidos mayores a $500"
            />
          </div>
          <div class="column is-3">
            <UiFeatureCard
              icon="bi bi-shield-check"
              title="Garantía"
              description="30 días de garantía"
            />
          </div>
          <div class="column is-3">
            <UiFeatureCard
              icon="bi bi-credit-card"
              title="Pago Seguro"
              description="Tus datos están protegidos"
            />
          </div>
          <div class="column is-3">
            <UiFeatureCard
              icon="bi bi-headset"
              title="Soporte 24/7"
              description="Siempre estamos para ayudarte"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">FAQ Accordion</h4>
        <div class="is-max-width-600">
          <UiFaqItem
            question="¿Cuál es el tiempo de entrega?"
            answer="El tiempo de entrega estimado es de 3 a 5 días hábiles. Para zonas rurales puede extenderse hasta 7 días."
          />
          <UiFaqItem
            question="¿Puedo devolver mi producto?"
            answer="Sí, tienes 30 días para realizar la devolución. El producto debe estar en su empaque original y sin uso."
          />
          <UiFaqItem
            question="¿Cómo contacto al soporte?"
            answer="Puedes contactarnos por WhatsApp, email o a través de nuestro formulario de contacto disponible en el sitio."
          />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Stat Values</h4>
        <div class="columns">
          <div class="column is-3">
            <UiStatValue
              value="1250"
              label="Ventas"
              icon="bi bi-cart"
              :change="12"
            />
          </div>
          <div class="column is-3">
            <UiStatValue
              value="4500"
              label="Usuarios"
              icon="bi bi-people"
              :change="-3"
            />
          </div>
          <div class="column is-3">
            <UiStatValue
              :value="28500"
              label="Ingresos"
              format="currency"
              icon="bi bi-currency-dollar"
              :change="8.5"
            />
          </div>
          <div class="column is-3">
            <UiStatValue
              :value="4.8"
              label="Rating"
              suffix="/ 5"
              icon="bi bi-star"
              :change="0"
            />
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Promotions</h3>
      <div class="mb-4">
        <h4 class="title is-5">Countdown Timer</h4>
        <div class="is-flex is-align-items-center gap-4">
          <UiPromotionCountdown
            :end-date="promotionEndDate"
            label="Termina en"
          />
          <UiPromotionCountdown
            :end-date="promotionEndDate"
            label="Oferta Flash"
            :show-days="false"
            :show-seconds="false"
            :compact="true"
          />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Feedback / States</h3>
      <div class="mb-4">
        <h4 class="title is-5">Loading State</h4>
        <div class="columns">
          <div class="column is-4">
            <UiLoadingState message="Cargando datos..." />
          </div>
          <div class="column is-4">
            <UiLoadingState message="Procesando..." :inline="true" />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Error State</h4>
        <div class="columns">
          <div class="column is-6">
            <UiErrorState
              title="Error de conexión"
              message="No pudimos conectarnos al servidor. Verifica tu conexión."
            />
          </div>
          <div class="column is-4">
            <UiErrorState
              title="Error"
              message="Algo salió mal."
              :show-retry="true"
              :compact="true"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Success State</h4>
        <div class="columns">
          <div class="column is-6">
            <UiSuccessState
              title="¡Pedido confirmado!"
              message="Recibimos tu pedido. Te notificaremos cuando esté listo."
            />
          </div>
          <div class="column is-4">
            <UiSuccessState
              title="Guardado"
              message="Cambios guardados."
              :compact="true"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Offline State</h4>
        <div class="columns">
          <div class="column is-6">
            <UiOfflineState />
          </div>
          <div class="column is-4">
            <UiOfflineState
              title="Sin WiFi"
              message="Revisa tu conexión."
              :compact="true"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Inline Messages</h4>
        <div class="is-flex is-flex-direction-column gap-3">
          <UiInlineMessage type="info" title="Información" message="Este es un mensaje informativo." />
          <UiInlineMessage type="success" message="¡Operación exitosa!" />
          <UiInlineMessage type="warning" title="Atención" message="Revisa los datos antes de continuar." />
          <UiInlineMessage type="error" message="Ocurrió un error inesperado." :dismissible="true" />
          <UiInlineMessage type="tip" title="Consejo" message="Usa atajos de teclado para ser más productivo." />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Status Badges</h4>
        <div class="is-flex is-flex-wrap-wrap gap-2 mb-3">
          <UiStatusBadge type="active" />
          <UiStatusBadge type="pending" />
          <UiStatusBadge type="approved" />
          <UiStatusBadge type="rejected" />
          <UiStatusBadge type="success" />
          <UiStatusBadge type="error" />
          <UiStatusBadge type="warning" />
          <UiStatusBadge type="info" />
          <UiStatusBadge type="new" />
          <UiStatusBadge type="featured" />
          <UiStatusBadge type="draft" />
          <UiStatusBadge type="archived" />
        </div>
        <div class="is-flex is-flex-wrap-wrap gap-2">
          <UiStatusBadge type="for_sale" label="En Venta" />
          <UiStatusBadge type="for_rent" label="En Renta" />
          <UiStatusBadge type="sold" label="Vendido" />
          <UiStatusBadge type="rented" label="Rentado" />
          <UiStatusBadge type="pending" label="Pendiente" />
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Empty State</h4>
        <div class="columns">
          <div class="column is-6">
            <UiEmptyState
              icon="bi bi-inbox"
              title="No hay resultados"
              description="No encontramos nada que coincida con tu búsqueda. Intenta con otros términos."
            />
          </div>
          <div class="column is-4">
            <UiEmptyState
              icon="bi bi-cart"
              title="Carrito vacío"
              :compact="true"
            />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Skeleton</h4>
        <div class="columns is-vcentered">
          <div class="column is-3">
            <h6 class="title is-6">Avatar variants</h6>
            <div class="is-flex is-align-items-center gap-3 mb-3">
              <UiSkeleton variant="circle-sm" />
              <UiSkeleton variant="circle" />
              <UiSkeleton variant="circle-lg" />
            </div>
          </div>
          <div class="column is-4">
            <h6 class="title is-6">Text variants</h6>
            <UiSkeleton variant="title" class="mb-2" />
            <UiSkeleton variant="text" class="mb-2" />
            <UiSkeleton variant="text" width="70%" />
          </div>
          <div class="column is-3">
            <h6 class="title is-6">Other variants</h6>
            <UiSkeleton variant="badge" class="mb-2" />
            <UiSkeleton variant="button" class="mb-2" />
            <UiSkeleton variant="thumbnail" />
          </div>
        </div>
        <div class="columns">
          <div class="column is-4">
            <h6 class="title is-6">Skeleton Card</h6>
            <UiSkeletonGroup variant="card" />
          </div>
          <div class="column is-4">
            <h6 class="title is-6">Skeleton List</h6>
            <UiSkeletonGroup variant="list" :rows="3" />
          </div>
          <div class="column is-4">
            <h6 class="title is-6">Skeleton Product</h6>
            <UiSkeletonGroup variant="product" />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Progress Bar</h4>
        <div class="columns">
          <div class="column is-6">
            <UiProgressBar v-model="progressValue" label="Progreso" :show-value="true" class="mb-4" />
            <UiProgressBar v-model="progressValue" variant="success" :show-value="true" class="mb-4" />
            <UiProgressBar v-model="progressValue" variant="warning" :show-value="true" class="mb-4" />
            <UiProgressBar v-model="progressValue" variant="danger" :show-value="true" />
          </div>
          <div class="column is-6">
            <UiProgressBar :model-value="30" variant="primary" size="sm" label="Small" class="mb-3" />
            <UiProgressBar :model-value="50" variant="success" size="md" label="Medium" class="mb-3" />
            <UiProgressBar :model-value="75" variant="warning" size="lg" label="Large" class="mb-3" />
            <UiProgressBar variant="primary" :indeterminate="true" label="Indeterminate" />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Step Indicator</h4>
        <div class="mb-4">
          <UiStepIndicator
            :steps="['Cuenta', 'Pago', 'Envío', 'Confirmar']"
            :current-step="1"
          />
        </div>
        <UiStepIndicator
          :steps="[
            { label: 'Carrito', description: 'Revisar productos' },
            { label: 'Pago', description: 'Datos de pago' },
            { label: 'Envío', description: 'Dirección' },
          ]"
          :current-step="2"
          :clickable="true"
        />
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Timeline</h4>
        <div class="columns">
          <div class="column is-6">
            <UiTimeline :items="timelineItems" />
          </div>
          <div class="column is-4">
            <UiTimeline :items="timelineItems" :compact="true" />
          </div>
        </div>
      </div>

      <div class="mb-4">
        <h4 class="title is-5">Alert</h4>
        <div class="is-flex is-flex-direction-column gap-3">
          <UiAlert type="info" title="Información" message="Este es un mensaje informativo." />
          <UiAlert type="success" title="¡Éxito!" message="La operación se completó correctamente." />
          <UiAlert type="warning" title="Advertencia" message="Revisa los datos antes de continuar." />
          <UiAlert type="error" title="Error" message="Ocurrió un error inesperado." :dismissible="true" />
          <UiAlert type="tip" title="Consejo" message="Usa atajos de teclado para ser más productivo." />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiProductCard from '@/Components/Ui/products/ProductCard.vue'
import UiServiceCard from '@/Components/Ui/services/ServiceCard.vue'
import UiServiceListItem from '@/Components/Ui/services/ServiceListItem.vue'
import UiVideoPlaylist from '@/Components/Ui/VideoPlaylist.vue'
import UiMiniCalendar from '@/Components/Ui/calendar/MiniCalendar.vue'
import UiAvailabilityStatus from '@/Components/Ui/availability/AvailabilityStatus.vue'
import UiOpeningHours from '@/Components/Ui/availability/OpeningHours.vue'
import UiSocialLinks from '@/Components/Ui/social/SocialLinks.vue'
import UiContactList from '@/Components/Ui/contact/ContactList.vue'
import UiContactAction from '@/Components/Ui/contact/ContactAction.vue'
import UiBusinessStatus from '@/Components/Ui/business/BusinessStatus.vue'
import UiRating from '@/Components/Ui/reviews/Rating.vue'
import UiReviewCard from '@/Components/Ui/reviews/ReviewCard.vue'
import UiEventDate from '@/Components/Ui/events/EventDate.vue'
import UiLocationCard from '@/Components/Ui/location/LocationCard.vue'
import UiTeamMember from '@/Components/Ui/people/TeamMember.vue'
import UiTeamGrid from '@/Components/Ui/people/TeamGrid.vue'
import UiTimeSlot from '@/Components/Ui/availability/TimeSlot.vue'
import UiBookingProgress from '@/Components/Ui/booking/BookingProgress.vue'
import UiBookingSummary from '@/Components/Ui/booking/BookingSummary.vue'
import UiReviewSummary from '@/Components/Ui/reviews/ReviewSummary.vue'
import UiEventTime from '@/Components/Ui/events/EventTime.vue'
import UiEventLocation from '@/Components/Ui/events/EventLocation.vue'
import UiEventCard from '@/Components/Ui/events/EventCard.vue'
import UiAddressBlock from '@/Components/Ui/location/AddressBlock.vue'
import UiDirectionsButton from '@/Components/Ui/location/DirectionsButton.vue'
import UiPrice from '@/Components/Ui/pricing/Price.vue'
import UiOldPrice from '@/Components/Ui/pricing/OldPrice.vue'
import UiDiscount from '@/Components/Ui/pricing/Discount.vue'
import UiPropertyCard from '@/Components/Ui/properties/PropertyCard.vue'
import UiPropertyPrice from '@/Components/Ui/properties/PropertyPrice.vue'
import UiPropertyStatus from '@/Components/Ui/properties/PropertyStatus.vue'
import UiPropertyFeatures from '@/Components/Ui/properties/PropertyFeatures.vue'
import UiProductStock from '@/Components/Ui/products/ProductStock.vue'
import UiProductImage from '@/Components/Ui/products/ProductImage.vue'
import UiProductGallery from '@/Components/Ui/products/ProductGallery.vue'
import UiProductMeta from '@/Components/Ui/products/ProductMeta.vue'
import UiProductVariant from '@/Components/Ui/products/ProductVariant.vue'
import UiShareButton from '@/Components/Ui/actions/ShareButton.vue'
import UiCopyButton from '@/Components/Ui/actions/CopyButton.vue'
import UiFavoriteButton from '@/Components/Ui/actions/FavoriteButton.vue'
import UiQuantitySelector from '@/Components/Ui/actions/QuantitySelector.vue'
import UiFeatureCard from '@/Components/Ui/content/FeatureCard.vue'
import UiPromotionCountdown from '@/Components/Ui/promotions/PromotionCountdown.vue'
import UiFaqItem from '@/Components/Ui/content/FaqItem.vue'
import UiStatValue from '@/Components/Ui/content/StatValue.vue'
import UiLoadingState from '@/Components/Ui/feedback/LoadingState.vue'
import UiErrorState from '@/Components/Ui/feedback/ErrorState.vue'
import UiSuccessState from '@/Components/Ui/feedback/SuccessState.vue'
import UiOfflineState from '@/Components/Ui/feedback/OfflineState.vue'
import UiInlineMessage from '@/Components/Ui/feedback/InlineMessage.vue'
import UiStatusBadge from '@/Components/Ui/feedback/StatusBadge.vue'
import UiEmptyState from '@/Components/Ui/feedback/EmptyState.vue'
import UiSkeleton from '@/Components/Ui/feedback/Skeleton.vue'
import UiSkeletonGroup from '@/Components/Ui/feedback/SkeletonGroup.vue'
import UiProgressBar from '@/Components/Ui/feedback/ProgressBar.vue'
import UiStepIndicator from '@/Components/Ui/feedback/StepIndicator.vue'
import UiTimeline from '@/Components/Ui/feedback/Timeline.vue'
import UiAlert from '@/Components/Ui/feedback/Alert.vue'

const selectedDate = ref(new Date())
const progressValue = ref(65)
const selectedTime = ref(null)
const currentStep = ref(1)
const selectedColor = ref('blue')
const selectedSize = ref('m')
const currentImage = ref(0)
const quantity = ref(1)
const favorite = ref(false)

const colorOptions = [
  { value: 'red', label: 'Rojo', color: '#dc2626' },
  { value: 'blue', label: 'Azul', color: '#2563eb' },
  { value: 'green', label: 'Verde', color: '#16a34a' },
  { value: 'black', label: 'Negro', color: '#171717' },
]

const sizeOptions = [
  { value: 'xs', label: 'XS' },
  { value: 's', label: 'S' },
  { value: 'm', label: 'M' },
  { value: 'l', label: 'L' },
  { value: 'xl', label: 'XL', disabled: true },
]

const galleryImages = ref([
  { url: 'https://picsum.photos/600/450?random=211', alt: 'Product 1' },
  { url: 'https://picsum.photos/600/450?random=212', alt: 'Product 2' },
  { url: 'https://picsum.photos/600/450?random=213', alt: 'Product 3' },
  { url: 'https://picsum.photos/600/450?random=214', alt: 'Product 4' },
])

const promotionEndDate = new Date(Date.now() + 3 * 24 * 60 * 60 * 1000 + 5 * 60 * 60 * 1000)

const timelineItems = ref([
  { date: '2026-09-01', title: 'Pedido recibido', description: 'Tu pedido #1234 fue recibido.', variant: 'success' },
  { date: '2026-09-02', title: 'Procesando', description: 'Estamos preparando tu pedido.', variant: 'primary' },
  { date: '2026-09-03', title: 'Enviado', description: 'Paquete en camino a tu dirección.', variant: 'info' },
  { date: '2026-09-05', title: 'Entregado', description: '¡Paquete entregado exitosamente!', variant: 'success' },
])

const calendarEvents = ref([
  { id: 1, date: new Date(), title: 'Evento' },
  { id: 2, date: new Date(Date.now() + 86400000 * 2), title: 'Otro evento' },
])

const teamMembers = ref([
  { name: 'Juan Pérez', role: 'Director General', bio: 'Más de 15 años de experiencia.', image: 'https://picsum.photos/200/200?random=61', social: [{ network: 'linkedin', url: '#' }] },
  { name: 'Ana López', role: 'Diseñadora', bio: 'Especialista en UX/UI.', image: 'https://picsum.photos/200/200?random=62', social: [{ network: 'instagram', url: '#' }] },
  { name: 'Carlos Ruiz', role: 'Desarrollador', image: 'https://picsum.photos/200/200?random=63', social: [{ network: 'github', url: '#' }] },
  { name: 'María Torres', role: 'Marketing', image: 'https://picsum.photos/200/200?random=64', social: [] },
])

const timeSlots = ref([
  { time: '09:00', disabled: false },
  { time: '09:30', disabled: false },
  { time: '10:00', disabled: false },
  { time: '10:30', disabled: true },
  { time: '11:00', disabled: false },
  { time: '11:30', disabled: false },
  { time: '12:00', disabled: false },
])

const businessSchedule = ref({
  monday: { open: '09:00', close: '18:00' },
  tuesday: { open: '09:00', close: '18:00' },
  wednesday: { open: '09:00', close: '18:00' },
  thursday: { open: '09:00', close: '18:00' },
  friday: { open: '09:00', close: '20:00' },
  saturday: { open: '10:00', close: '14:00' },
  sunday: {},
})

const socialItems = ref([
  { network: 'instagram', url: 'https://instagram.com/example' },
  { network: 'facebook', url: 'https://facebook.com/example' },
  { network: 'whatsapp', url: 'https://wa.me/521234567890' },
  { network: 'twitter', url: 'https://twitter.com/example' },
  { network: 'youtube', url: 'https://youtube.com/@example' },
])

const contactItems = ref([
  { type: 'phone', value: '+52 55 1234 5678', label: 'Teléfono' },
  { type: 'whatsapp', value: '+52 55 1234 5678', label: 'WhatsApp' },
  { type: 'email', value: 'contacto@ejemplo.com', label: 'Email' },
  { type: 'website', value: 'https://ejemplo.com', label: 'Sitio web' },
  { type: 'address', value: 'Av. Principal 123, CDMX', label: 'Dirección' },
])

const videoPlaylistItems = ref([
  {
    id: 1,
    title: 'Introduction to Bulma',
    duration: '5:30',
    thumbnail: 'https://picsum.photos/160/90?random=1',
    video: 'https://www.w3schools.com/html/mov_bbb.mp4'
  },
  {
    id: 2,
    title: 'Building Layouts',
    duration: '12:45',
    thumbnail: 'https://picsum.photos/160/90?random=2',
    video: 'https://www.w3schools.com/html/mov_bbb.mp4'
  },
  {
    id: 3,
    title: 'Components Overview',
    duration: '8:20',
    thumbnail: 'https://picsum.photos/160/90?random=3',
    video: 'https://www.w3schools.com/html/mov_bbb.mp4'
  },
  {
    id: 4,
    title: 'Advanced Techniques',
    duration: '15:10',
    thumbnail: 'https://picsum.photos/160/90?random=4',
    video: 'https://www.w3schools.com/html/mov_bbb.mp4'
  }
])
</script>

<style lang="scss" scoped>
.playground-section {
  padding: 1rem 0;
}

.mb-4 {
  margin-bottom: 1rem;
}
</style>
