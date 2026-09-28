import js from '@eslint/js'
import globals from 'globals'
import reactHooks from 'eslint-plugin-react-hooks'
import reactRefresh from 'eslint-plugin-react-refresh'
import tseslint from 'typescript-eslint'
import { defineConfig, globalIgnores } from 'eslint/config'

export default defineConfig([
  globalIgnores(['dist']),
  {
    files: ['**/*.{ts,tsx}'],
    extends: [
      js.configs.recommended,
      tseslint.configs.recommended,
      reactHooks.configs.flat.recommended,
      reactRefresh.configs.vite,
    ],
    languageOptions: {
      globals: globals.browser,
    },
  },
  {
    // File ini memang sengaja menggabungkan komponen + helper/hook
    // (context+useRole, daftar rute+guard), jadi rule fast-refresh dilepas.
    files: ['src/lib/role.tsx', 'src/routes.tsx'],
    rules: {
      'react-refresh/only-export-components': 'off',
    },
  },
])
