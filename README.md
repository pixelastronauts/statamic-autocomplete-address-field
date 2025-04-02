# Statamic Autocomplete Address Field

The Statamic Autocomplete Address Field is a powerful addon for Statamic CMS that integrates a straightforward yet highly effective address input field featuring Google Maps Autocomplete. This tool simplifies the process of entering and storing comprehensive address data directly within your CMS.

## Key Features

- **Google Maps Autocomplete**: Enhances text input fields with autocomplete functionality for addresses, leveraging Google Maps.
- **Updated Places API**: Uses the new Google Maps Place class API (when available) for improved performance and modern features.
- **Comprehensive Data Storage**: Automatically stores detailed address information along with geographical coordinates. Example data structure includes:
  - `street_number`: e.g., "42A"
  - `route`: e.g., "Prinsestraat"
  - `locality`: e.g., "Den Haag"
  - `administrative_area_level_1`: e.g., "Zuid-Holland"
  - `country`: e.g., "Nederland"
  - `postal_code`: e.g., "2513 CE"
  - `formatted_address`: e.g., "Prinsestraat 42A, 2513 CE Den Haag, Nederland"
  - `coordinates`:
    - `lat`: 52.0787948
    - `lng`: 4.305637
- **Configurable Options**: Allows for country-specific configuration in the fieldset settings.

## Installation

To install the Statamic Address Field, you can either use the Statamic control panel or a command line interface:

- **Via Control Panel**: Navigate to `Tools > Addons` in the Statamic control panel, search for "Address Field", and click **Install**.
- **Via Command Line**:
  ```bash
  composer require pixelastronauts/statamic-autocomplete-address-field
  ```

## Usage

To utilize the Address Field addon:

1. **API Key Setup**: Ensure that your 'GOOGLE_PLACES_API_KEY' is added to your project's `.env` file and properly restricted. Make sure you have the new Places API (New) enabled in your Google Cloud project.
2. **Field Configuration**: Configure the desired country and other settings in your fieldset configuration file as needed.
3. **Integration**: Add the Address Field to your relevant templates or blueprints within Statamic, and it will automatically incorporate Google Maps Autocomplete functionality.

## Google Maps API Updates

This addon supports both the legacy Places API and the new Place class API. The implementation will automatically use the new API if available, with a fallback to the legacy API.

### Key Benefits of the New Place API:

- Improved performance
- Modern Promise-based async interface
- Updated data field structure using camelCase conventions
- Expanded place types and data fields

### Migration Notes:

- Enable "Places API (New)" in your Google Cloud project
- The addon handles backward compatibility automatically
- No changes needed for existing templates or content

This addon significantly streamlines address entry and enhances data accuracy.
