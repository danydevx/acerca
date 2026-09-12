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

    <form @submit.prevent="submit">
      <div class="card">
        <div class="card-header bg-transparent border-bottom pb-2 pt-2 d-flex justify-content-between align-items-center">
          <h6 class="text-uppercase text-muted mb-0 fw-normal">
            <i class="bi bi-gear me-1"></i>Configuracion de pedidos
          </h6>
          <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" id="isActive" v-model="form.is_active">
            <label class="form-check-label" for="isActive">Activo</label>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-3 mb-3">
            <div class="col-12">
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

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Configuración de Delivery</h6>
            </div>

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

            <div class="col-12">
              <hr />
              <h6 class="mb-3">Pedido mínimo</h6>
            </div>

            <div class="col-md-6">
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

            <div class="col-12">
              <hr />
              <h6 class="mb-3">WhatsApp</h6>
            </div>

            <div class="col-md-6">
              <FieldText
                id="whatsapp-number"
                label="Número de WhatsApp (con código de país)"
                v-model="form.whatsapp_number"
                placeholder="5215512345678"
                help-text="Los pedidos se enviarán a este número. Include código de país (ej: 52 para México)."
              />
            </div>
          </div>
        </div>
        <div class="card-footer bg-transparent border-top pt-3 pb-3">
          <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary rounded-pill py-2" :disabled="saving">
              {{ saving ? 'Guardando...' : 'Guardar configuración' }}
            </button>
            <Link :href="`/member/listings/${listing?.id}/orders`" class="btn btn-secondary rounded-pill py-2">
              Cancelar
            </Link>
          </div>
        </div>
      </div>
    </form>
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
