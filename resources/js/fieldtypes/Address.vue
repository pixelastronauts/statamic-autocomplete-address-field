<template>
	<div>
		<text-input
			:type="inputType"
			ref="input"
			:value="displayAddress"
			@input="updateDebounced"
		/>
		<small
			class="text-red-500"
			v-if="!meta.hasKey"
		>
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
			if (!this.meta.hasKey) return;

			// Use a setTimeout to ensure Google Maps is fully loaded
			setTimeout(() => {
				this.initializePlace();
			}, 500);
		},
		methods: {
			initializePlace() {
				try {
					if (
						!window.google ||
						!window.google.maps ||
						!window.google.maps.places
					) {
						console.error("Google Maps Places API not available");
						return;
					}

					const countryCodes =
						this.config?.country_code &&
						typeof this.config.country_code === "string"
							? this.config.country_code.split(",").map((code) => code.trim())
							: [];

					const input = this.$refs.input.$el.querySelector("input");

					// Use the modern Autocomplete class directly
					this.autocomplete = new google.maps.places.Autocomplete(input, {
						componentRestrictions: { country: countryCodes },
						fields: [
							"address_components",
							"geometry",
							"formatted_address",
							"place_id",
						],
					});

					// Add event listener for place selection
					this.autocomplete.addListener("place_changed", this.onPlaceChanged);
				} catch (error) {
					console.error("Error initializing Google Maps Places:", error);
				}
			},

			updateDebounced: _.debounce(function (value) {
				this.displayAddress = value;

				// If the value is empty, emit an empty value to allow clearing the field
				if (!value || value.trim() === "") {
					this.addressObject = {};
					this.$emit("input", null);
					return;
				}

				// Otherwise update just the formatted_address in the existing object
				this.addressObject = {
					...this.addressObject,
					formatted_address: value,
				};

				this.$emit("input", this.addressObject);
			}, 500),

			onPlaceChanged() {
				try {
					const place = this.autocomplete.getPlace();
					if (!place || !place.geometry) {
						console.log("No details available for input");
						return;
					}

					const addressComponents = {};

					// Process address components
					place.address_components.forEach((component) => {
						const types = component.types;
						if (types.includes("street_number")) {
							addressComponents.street_number = component.long_name;
						} else if (types.includes("route")) {
							addressComponents.route = component.long_name;
						} else if (types.includes("locality")) {
							addressComponents.locality = component.long_name;
						} else if (types.includes("administrative_area_level_1")) {
							addressComponents.administrative_area_level_1 =
								component.long_name;
						} else if (types.includes("country")) {
							addressComponents.country = component.long_name;
						} else if (types.includes("postal_code")) {
							addressComponents.postal_code = component.long_name;
						}
					});

					// Create the final address object
					const address = {
						street_number: addressComponents.street_number || "",
						route: addressComponents.route || "",
						locality: addressComponents.locality || "",
						administrative_area_level_1:
							addressComponents.administrative_area_level_1 || "",
						country: addressComponents.country || "",
						postal_code: addressComponents.postal_code || "",
						formatted_address: place.formatted_address,
						place_id: place.place_id,
						coordinates: {
							lat: place.geometry.location.lat(),
							lng: place.geometry.location.lng(),
						},
					};

					this.displayAddress = address.formatted_address;
					this.addressObject = address;

					this.$emit("input", address);
				} catch (error) {
					console.error("Error handling place selection:", error);
				}
			},
		},
	};
</script>
