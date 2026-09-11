# FASE 3D.9 — BASELINE

## Routes before: 972

## ListingContentController routes: 56

## Physical root controllers: 90

## Method inventory

| METHOD | DOMAIN | ACTION | MODEL | TARGET MODULE |
|--------|--------|--------|-------|---------------|
| locationsIndex | LOCATIONS | admin.business.locations.index | ListingLocation | ListingLocations |
| locationsCreate | LOCATIONS | admin.business.locations.create | - | ListingLocations |
| locationsStore | LOCATIONS | admin.business.locations.store | ListingLocation | ListingLocations |
| locationsEdit | LOCATIONS | admin.business.locations.edit | ListingLocation | ListingLocations |
| locationsUpdate | LOCATIONS | admin.business.locations.update | ListingLocation | ListingLocations |
| locationsDestroy | LOCATIONS | admin.business.locations.destroy | ListingLocation | ListingLocations |
| servicesIndex | SERVICES | admin.business.services.index | ListingService | ListingServices |
| servicesCreate | SERVICES | admin.business.services.create | - | ListingServices |
| servicesStore | SERVICES | admin.business.services.store | ListingService | ListingServices |
| servicesEdit | SERVICES | admin.business.services.edit | ListingService | ListingServices |
| servicesUpdate | SERVICES | admin.business.services.update | ListingService | ListingServices |
| servicesDestroy | SERVICES | admin.business.services.destroy | ListingService | ListingServices |
| faqsIndex | FAQS | admin.business.faqs.index | ListingFaq | ListingFaqs |
| faqsCreate | FAQS | admin.business.faqs.create | - | ListingFaqs |
| faqsStore | FAQS | admin.business.faqs.store | ListingFaq | ListingFaqs |
| faqsEdit | FAQS | admin.business.faqs.edit | ListingFaq | ListingFaqs |
| faqsUpdate | FAQS | admin.business.faqs.update | ListingFaq | ListingFaqs |
| faqsDestroy | FAQS | admin.business.faqs.destroy | ListingFaq | ListingFaqs |
| faqCategoriesIndex | FAQ_CATEGORIES | admin.business.faq-categories.index | ListingFaqCategory | ListingFaqs |
| faqCategoriesStore | FAQ_CATEGORIES | admin.business.faq-categories.store | ListingFaqCategory | ListingFaqs |
| faqCategoriesUpdate | FAQ_CATEGORIES | admin.business.faq-categories.update | ListingFaqCategory | ListingFaqs |
| faqCategoriesDestroy | FAQ_CATEGORIES | admin.business.faq-categories.destroy | ListingFaqCategory | ListingFaqs |
| productCategoriesIndex | PRODUCT_CATEGORIES | admin.business.product-categories.index | ListingProductCategory | ListingProducts |
| productCategoriesStore | PRODUCT_CATEGORIES | admin.business.product-categories.store | ListingProductCategory | ListingProducts |
| productCategoriesUpdate | PRODUCT_CATEGORIES | admin.business.product-categories.update | ListingProductCategory | ListingProducts |
| productCategoriesDestroy | PRODUCT_CATEGORIES | admin.business.product-categories.destroy | ListingProductCategory | ListingProducts |
| serviceCategoriesIndex | SERVICE_CATEGORIES | admin.business.service-categories.index | ListingServiceCategory | ListingServices |
| serviceCategoriesStore | SERVICE_CATEGORIES | admin.business.service-categories.store | ListingServiceCategory | ListingServices |
| serviceCategoriesUpdate | SERVICE_CATEGORIES | admin.business.service-categories.update | ListingServiceCategory | ListingServices |
| serviceCategoriesDestroy | SERVICE_CATEGORIES | admin.business.service-categories.destroy | ListingServiceCategory | ListingServices |
| productsIndex | PRODUCTS | admin.business.products.index | ListingProduct | ListingProducts |
| productsCreate | PRODUCTS | admin.business.products.create | - | ListingProducts |
| productsStore | PRODUCTS | admin.business.products.store | ListingProduct | ListingProducts |
| productsEdit | PRODUCTS | admin.business.products.edit | ListingProduct | ListingProducts |
| productsUpdate | PRODUCTS | admin.business.products.update | ListingProduct | ListingProducts |
| productsDestroy | PRODUCTS | admin.business.products.destroy | ListingProduct | ListingProducts |
| galleryIndex | GALLERY | admin.business.gallery.index | ListingGalleryImage | ListingGallery |
| galleryStore | GALLERY | admin.business.gallery.store | ListingGalleryImage | ListingGallery |
| galleryUpdate | GALLERY | admin.business.gallery.update | ListingGalleryImage | ListingGallery |
| galleryDestroy | GALLERY | admin.business.gallery.destroy | ListingGalleryImage | ListingGallery |
| galleriesIndex | GALLERIES | admin.business.galleries.index | ListingGallery | ListingGallery |
| galleriesCreate | GALLERIES | admin.business.galleries.create | - | ListingGallery |
| galleriesStore | GALLERIES | admin.business.galleries.store | ListingGallery | ListingGallery |
| galleriesEdit | GALLERIES | admin.business.galleries.edit | ListingGallery | ListingGallery |
| galleriesUpdate | GALLERIES | admin.business.galleries.update | ListingGallery | ListingGallery |
| galleriesDestroy | GALLERIES | admin.business.galleries.destroy | ListingGallery | ListingGallery |
| galleriesSetPrimary | GALLERIES | admin.business.galleries.set-primary | ListingGallery | ListingGallery |
| appointmentsIndex | APPOINTMENTS | admin.business.appointments.index | ListingAppointment | ListingAppointments |
| appointmentsCreate | APPOINTMENTS | admin.business.appointments.create | - | ListingAppointments |
| appointmentsStore | ADMIN | admin.business.appointments.store | ListingAppointment | ListingAppointments |
| appointmentsShow | APPOINTMENTS | admin.business.appointments.show | ListingAppointment | ListingAppointments |
| appointmentsEdit | APPOINTMENTS | admin.business.appointments.edit | ListingAppointment | ListingAppointments |
| appointmentsUpdate | APPOINTMENTS | admin.business.appointments.update | ListingAppointment | ListingAppointments |
| appointmentsDestroy | APPOINTMENTS | admin.business.appointments.destroy | ListingAppointment | ListingAppointments |
| appointmentsCancel | APPOINTMENTS | admin.business.appointments.cancel | ListingAppointment | ListingAppointments |

## Domain summary

| DOMAIN | ROUTES | MODULE |
|--------|--------|--------|
| FAQ_CATEGORIES | 4 | ListingFaqs |
| FAQS | 6 | ListingFaqs |
| PRODUCT_CATEGORIES | 4 | ListingProducts |
| SERVICE_CATEGORIES | 4 | ListingServices |
| PRODUCTS | 6 | ListingProducts |
| GALLERY (singular) | 4 | ListingGallery |
| GALLERIES (plural) | 7 | ListingGallery |
| LOCATIONS | 6 | ListingLocations |
| APPOINTMENTS | 8 | ListingAppointments |
| **TOTAL** | **56** | |
