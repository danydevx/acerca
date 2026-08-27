window.Analytics = {
  _endpoint: '/analytics/collect',
  _listingSlug: null,
  _queue: [],

  init(listingSlug) {
    this._listingSlug = listingSlug;
    this._processQueue();
    this._trackPageview();
    this._setupHistoryTracking();
  },

  _send(data) {
    if (!this._listingSlug) {
      this._queue.push(data);
      return;
    }

    const payload = {
      ...data,
      path: data.path || window.location.pathname,
      url: data.url || window.location.href,
      referrer: document.referrer || null,
      screen_width: window.screen.width,
      screen_height: window.screen.height,
    };

    fetch(this._endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(payload),
    }).catch(() => {});
  },

  _processQueue() {
    while (this._queue.length > 0) {
      const data = this._queue.shift();
      this._send(data);
    }
  },

  _trackPageview() {
    this._send({ type: 'pageview' });
  },

  _setupHistoryTracking() {
    const originalPushState = history.pushState;
    const self = this;

    history.pushState = function() {
      originalPushState.apply(this, arguments);
      self._trackPageview();
    };

    window.addEventListener('popstate', () => {
      this._trackPageview();
    });
  },

  trackPageview(path) {
    this._send({ type: 'pageview', path });
  },

  trackEvent(eventName, metadata = {}) {
    this._send({
      type: 'event',
      event_name: eventName,
      metadata,
    });
  },

  trackWhatsappClick(metadata = {}) {
    this.trackEvent('whatsapp_click', metadata);
  },

  trackPhoneClick(metadata = {}) {
    this.trackEvent('phone_click', metadata);
  },

  trackEmailClick(metadata = {}) {
    this.trackEvent('email_click', metadata);
  },

  trackContactFormSubmit(metadata = {}) {
    this.trackEvent('contact_form_submit', metadata);
  },

  trackAppointmentClick(metadata = {}) {
    this.trackEvent('appointment_click', metadata);
  },

  trackProductClick(metadata = {}) {
    this.trackEvent('product_click', metadata);
  },

  trackServiceClick(metadata = {}) {
    this.trackEvent('service_click', metadata);
  },

  trackPropertyClick(metadata = {}) {
    this.trackEvent('property_click', metadata);
  },

  trackMapClick(metadata = {}) {
    this.trackEvent('map_click', metadata);
  },

  trackSocialClick(metadata = {}) {
    this.trackEvent('social_click', metadata);
  },

  trackDownloadVcard(metadata = {}) {
    this.trackEvent('download_vcard', metadata);
  },

  trackDownloadFile(metadata = {}) {
    this.trackEvent('download_file', metadata);
  },

  trackGalleryOpen(metadata = {}) {
    this.trackEvent('gallery_open', metadata);
  },

  trackVideoPlay(metadata = {}) {
    this.trackEvent('video_play', metadata);
  },

  trackCtaClick(metadata = {}) {
    this.trackEvent('cta_click', metadata);
  },
};
