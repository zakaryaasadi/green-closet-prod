const {defineConfig} = require("cypress");

module.exports = defineConfig({
    chromeWebSecurity: false,
    fixturesFolder: "tests/cypress/fixtures",
    screenshotsFolder: "./storage/cypress/screenshots",
    videosFolder: "./storage/cypress/videos",
    downloadsFolder: "./storage/cypress/downloads",
    e2e: {
        supportFile: "tests/cypress/support/e2e.js",
        specPattern: "tests/cypress/e2e/**/*.cy.{js,jsx,ts,tsx}",
        setupNodeEvents(on, config) {
            // implement node event listeners here
        },

    },
});
