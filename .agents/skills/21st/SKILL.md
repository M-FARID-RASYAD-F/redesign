---
name: 21st
description: >-
  Search, install, preview, generate, and publish React/shadcn/Tailwind UI components, themes, and templates using 21st.dev and the 21st CLI (`@21st-dev/cli`). Use whenever the user asks to find/install components from 21st, use 21st.dev, sketch UI with 21st AI, sync design tokens as themes, or publish components to the 21st registry.
---

# 21st.dev — UI Components, Themes & AI Drafting

21st.dev is the largest open-source component and theme registry for React, shadcn/ui, Tailwind CSS, and Framer Motion. This skill gives you full mastery of the `21st` CLI (`npx @21st-dev/cli` or `21st`).

---

## 1. Quick Setup & Authentication

Run commands using `npx @21st-dev/cli <command>` or install globally via `npm i -g @21st-dev/cli`.

### Auth Options:
1. **Interactive Login (Browser)**:
   ```bash
   npx @21st-dev/cli login
   ```
2. **API Key (Environment / Non-interactive)**:
   Set `TWENTYFIRST_TOKEN` or `API_KEY_21ST` environment variable, or pass `--api-key <key>`.
   Get your key from [21st.dev/settings/api-keys](https://21st.dev/settings/api-keys).

Check account status and remaining free quota:
```bash
npx @21st-dev/cli whoami
npx @21st-dev/cli usage
```

---

## 2. Searching & Installing Components (`21st-cli-use`)

**Rule: Always search 21st before hand-writing complex components from scratch.**

### Search the Catalog:
```bash
# Search all items (components, themes, templates)
npx @21st-dev/cli search "pricing table" --limit 10

# Search components only
npx @21st-dev/cli search "animated button" --type c

# Search themes
npx @21st-dev/cli search "neon dark" --type theme

# Filter by tags, colors, sort
npx @21st-dev/cli search "hero section" --tag framer-motion --free --sort popular
```

### Inspect Component Details:
```bash
# View code & metadata for a component
npx @21st-dev/cli get aceternity/lamp-effect

# Print raw code
npx @21st-dev/cli get aceternity/lamp-effect --code

# View theme CSS tokens
npx @21st-dev/cli theme shadcn/midnight --css
```

### Install Component into Project:
```bash
# Install directly (auto-resolves dependencies & puts files into components/)
npx @21st-dev/cli add aceternity/lamp-effect

# Install with npm/pnpm/bun auto-detection
npx @21st-dev/cli add @username/component-name
```

---

## 3. Sketching & Iterating with 21st AI (`21st-ai`)

Use 21st AI to draft UI concepts fast:

1. **Generate UI Takes from Prompt**:
   ```bash
   npx @21st-dev/cli generate "a modern SaaS pricing table with monthly/annual switch and feature badges"
   ```
2. **List Generated Takes**:
   ```bash
   npx @21st-dev/cli generation <projectId>
   ```
3. **Iterate on a Variant**:
   ```bash
   npx @21st-dev/cli iterate <projectId> "make the popular tier glow with purple gradient border" --take 2
   ```
4. **Grab the Code / Implementation Spec**:
   ```bash
   # Handoff spec (recommended for adapting to project stack)
   npx @21st-dev/cli take <projectId> --take 2

   # Raw standalone HTML/Tailwind code
   npx @21st-dev/cli take <projectId> --take 2 --code
   ```

---

## 4. Syncing Design Tokens & Themes (`21st-design-sync`)

Extract and publish your project's design system tokens (Tailwind colors, radii, typography) as a 21st theme:
```bash
npx @21st-dev/cli sync-design
```

---

## 5. Publishing to Registry (`21st-registry`)

Publish custom components, themes, or templates for team or public use:
```bash
# Publish component from local file
npx @21st-dev/cli publish ./src/components/MyCustomButton.tsx --name "glow-button"

# Publish theme
npx @21st-dev/cli publish-theme ./styles/theme.css --name "cyberpunk"
```

---

## Sub-Skills Reference:
- `21st-cli-use`: Specialized search and installation workflows
- `21st-ai`: Fast UI generation, prompt engineering, and take refinement
- `21st-design-sync`: Theme synchronization and CSS token extraction
- `21st-registry`: Registry management, versioning, and publishing
