<template>
  <div>
    <text-input
      :type="inputType"
      ref="input"
      :value="displayAddress"
      @input="updateDebounced"
    />
    <small class="text-red-500" v-if="!meta.hasKey">
      Google Maps key not (yet) configured
    </small>
    <input
      type="hidden"
      :value="JSON.stringify(addressObject)"
      ref="hiddenInput"
    />
  </div>
</template>

<script>
export default {
  mixins: [Fieldtype],
  data() {
    return {
      displayAddress: this.value ? this.value.formatted_address : "",
      addressObject: this.value || {},
      autocomplete: null,
    };
  },
  mounted() {
    const countryCodes = this.config.country_code
      .split(",")
      .map((code) => code.trim());

    const options = {
      componentRestrictions: { country: countryCodes },
      fields: ["address_components", "geometry", "formatted_address"],
    };
    var input = this.$refs.input.$el.querySelector("input");

    this.autocomplete = new google.maps.places.Autocomplete(input, options);

    this.autocomplete.addListener("place_changed", this.onPlaceChanged);
  },
  methods: {
    updateDebounced: _.debounce(function (value) {
      this.displayAddress = value;
      this.addressObject = { ...this.addressObject, formatted_address: value };
    }, 500),

    onPlaceChanged() {
      const place = this.autocomplete.getPlace();
      if (!place.geometry) {
        console.log("No details available for input: '" + place.name + "'");
        return;
      }

      const addressComponents = place.address_components.reduce(
        (acc, component) => {
          const types = component.types;
          if (types.includes("street_number")) {
            acc.street_number = component.long_name;
          } else if (types.includes("route")) {
            acc.route = component.long_name;
          } else if (types.includes("locality")) {
            acc.locality = component.long_name;
          } else if (types.includes("administrative_area_level_1")) {
            acc.administrative_area_level_1 = component.long_name;
          } else if (types.includes("country")) {
            acc.country = component.long_name;
          } else if (types.includes("postal_code")) {
            acc.postal_code = component.long_name;
          }
          return acc;
        },
        {}
      );

      const address = {
        street_number: addressComponents.street_number || "",
        route: addressComponents.route || "",
        locality: addressComponents.locality || "",
        administrative_area_level_1:
          addressComponents.administrative_area_level_1 || "",
        country: addressComponents.country || "",
        postal_code: addressComponents.postal_code || "",
        formatted_address: place.formatted_address,
        coordinates: {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng(),
        },
      };

      this.displayAddress = address.formatted_address;
      this.addressObject = address;

      this.$emit("input", address);
    },
  },
};
</script>
