<template>
  <MemberLayout>
    <Head :title="`Configuración de Pedidos - ${listing?.name || ''}`" />

    <PageHeader
      title="Configuración de Pedidos"
      :breadcrumbs="breadcrumbs"
      :backHref="`/member/listings/${listing?.id}/orders`"
    />

    <div v-if="$page.props.flash?.success" class="alert alert-success alert-dismissible fade show">
      {{ $page.props.flash.success }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="mb-4">
                <div class="form-check form-switch mb-3">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    id="isActive"
                    v-model="form.is_active"
                  />
                  <label class="form-check-label" for="isActive">
                    <strong>Activar sistema de pedidos</strong>
                  </label>
                </div>
                <p class="text-muted small">
                  Si está desactivado, los clientes no podrán realizar pedidos en el minisite público.
                </p>
              </div>

              <hr />

              <h6 class="mb-3">Tipos de entrega</h6>
              <div class="mb-4">
                <FieldSelect
                  id="order-type"
                  label="Tipos de entrega"
                  v-model="form.order_type"
                  :options="[
                    { value: 'both', label: 'Delivery y Recolección' },
                    { value: 'delivery', label: 'Solo Delivery' },
                    { value: 'pickup', label: 'Solo Recolección' }
                  ]"
                />
              </div>

              <hr />

              <h6 class="mb-3">Configuración de Delivery</h6>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <FieldNumber
                    id="delivery-radius"
                    label="Radio máximo de entrega (km)"
                    v-model="form.delivery_radius_km"
                    :min="1"
                    :max="100"
                  />
                </div>
                <div class="col-md-6">
                  <FieldNumber
                    id="delivery-fee-base"
                    label="Tarifa base de entrega ($)"
                    v-model="form.delivery_fee_base"
                    :min="0"
                    :step="0.01"
                  />
                </div>
              </div>

              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <FieldNumber
                    id="delivery-fee-per-km"
                    label="Costo por km adicional ($)"
                    v-model="form.delivery_fee_per_km"
                    :min="0"
                    :step="0.01"
                  />
                </div>
                <div class="col-md-6">
                  <FieldNumber
                    id="free-delivery-threshold"
                    label="Pedido mínimo para delivery gratis ($)"
                    v-model="form.free_delivery_threshold"
                    :min="0"
                    :step="0.01"
                    placeholder="Dejar vacío si no aplica"
                  />
                </div>
              </div>

              <hr />

              <h6 class="mb-3">Pedido mínimo</h6>
              <div class="mb-4">
                <FieldNumber
                  id="min-order-amount"
                  label="Monto mínimo de pedido ($)"
                  v-model="form.min_order_amount"
                  :min="0"
                  :step="0.01"
                  placeholder="0 = sin mínimo"
                  help-text="Los pedidos menores a este monto serán rechazados."
                />
              </div>

              <hr />

              <h6 class="mb-3">WhatsApp</h6>
              <div class="mb-4">
                <FieldText
                  id="whatsapp-number"
                  label="Número de WhatsApp (con código de país)"
                  v-model="form.whatsapp_number"
                  placeholder="5215512345678"
                  help-text="Los pedidos se enviarán a este número. Include código de país (ej: 52 para México)."
                />
              </div>

              <div class="d-flex gap-2">
                <button type="submit" class="btn btn-gradient rounded-pill" :disabled="saving">
                  {{ saving ? 'Guardando...' : 'Guardar configuración' }}
                </button>
                <Link :href="`/member/listings/${listing?.id}/orders`" class="btn btn-outline-dark rounded-pill">
                  Cancelar
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </MemberLayout>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import MemberLayout from '@/Layouts/MemberLayout.vue'
import PageHeader from '@/Components/Admin/PageHeader.vue'
import FieldSwitch from '@/Components/Fields/FieldSwitch.vue'
import FieldSelect from '@/Components/Fields/FieldSelect.vue'
import FieldNumber from '@/Components/Fields/FieldNumber.vue'
import FieldText from '@/Components/Fields/FieldText.vue'

const page = usePage()
const listing = computed(() => page.props.listing)
const setting = computed(() => page.props.setting || {})
const businessMenu = computed(() => page.props.businessMenu || [])

const saving = ref(false)

const form = reactive({
  is_active: setting.value.is_active ?? true,
  order_type: setting.value.order_type ?? 'both',
  delivery_radius_km: setting.value.delivery_radius_km ?? 10,
  delivery_fee_base: setting.value.delivery_fee_base ?? 30,
  delivery_fee_per_km: setting.value.delivery_fee_per_km ?? 3,
  free_delivery_threshold: setting.value.free_delivery_threshold ?? null,
  min_order_amount: setting.value.min_order_amount ?? 0,
  whatsapp_number: setting.value.whatsapp_number ?? '',
})

const breadcrumbs = computed(() => [
  { label: 'Inicio', href: '/member/dashboard' },
  { label: 'Pedidos', href: `/member/listings/${listing.value?.id}/orders` },
  { label: 'Configuración' },
])

const submit = () => {
  saving.value = true

  router.post(`/member/listings/${listing.value.id}/orders/settings`, form, {
    preserveScroll: true,
    onFinish: () => {
      saving.value = false
    },
  })
}
</script>
