export default [
  {
    files: ["assets/dist/js/**/*.js"],
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: "script",
      globals: {
        window: "readonly",
        document: "readonly",
        console: "readonly",
        agencyCore: "readonly",
        agencySiteData: "readonly",
        setTimeout: "readonly",
        clearTimeout: "readonly",
        fetch: "readonly",
        FormData: "readonly",
        navigator: "readonly"
      }
    },
    rules: {
      "no-undef": "error",
      "no-unused-vars": "warn",
      "no-unreachable": "error",
      "no-constant-condition": "warn"
    }
  }
];

