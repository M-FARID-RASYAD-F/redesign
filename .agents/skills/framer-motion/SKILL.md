---
name: framer-motion
description: "Production-grade animations, micro-interactions, and layout transitions using Motion (Framer Motion v12+, `motion/react`). Use when the user wants to add animations, transitions, gestures, scroll-linked effects, parallax, page transitions, spring physics, AnimatePresence, whileHover/whileTap, layoutId, or make a UI feel alive, dynamic, and fluid with 120fps GPU acceleration and accessibility (prefers-reduced-motion) compliance."
---

# Framer Motion & Motion.dev — Animation Intelligence

Comprehensive guide and standard patterns for production-grade React animations using **Motion** (Framer Motion v12+, package `motion/react`).

---

## 1. Installation & Imports

```bash
npm install motion
```

Always use the modern `motion/react` entry point (Framer Motion v12+):
```tsx
import { 
  motion, 
  AnimatePresence, 
  useScroll, 
  useTransform, 
  useSpring, 
  useMotionValue,
  useReducedMotion 
} from "motion/react"
```
*(Legacy note: for older projects on v10/v11, import from `framer-motion`)*

---

## 2. Golden Performance Rules (120 FPS GPU Acceleration)

1. **Animate ONLY composite properties**: `transform` (`x`, `y`, `scale`, `rotate`) and `opacity`.
   - ❌ **NEVER animate**: `width`, `height`, `top`, `left`, `margin`, `padding` (causes CPU layout thrashing).
   - ✅ **Use `layout` prop** when geometric dimensions must smoothly change.
2. **Reduced Motion**: Always respect user accessibility preferences:
   ```tsx
   const shouldReduceMotion = useReducedMotion()
   const initial = shouldReduceMotion ? { opacity: 0 } : { opacity: 0, y: 20 }
   ```
3. **Viewport Optimization**: Always use `viewport={{ once: true, margin: "-50px" }}` on scroll animations to prevent expensive re-renders.

---

## 3. Core Patterns

### A. Basic Motion & Spring Physics
```tsx
<motion.div
  initial={{ opacity: 0, y: 20 }}
  animate={{ opacity: 1, y: 0 }}
  exit={{ opacity: 0, y: -20 }}
  transition={{ 
    type: "spring", 
    stiffness: 300, 
    damping: 24, 
    mass: 0.8 
  }}
/>
```

### B. Coordinated Variants (Staggered Children)
```tsx
const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: {
      staggerChildren: 0.08,
      delayChildren: 0.1
    }
  }
}

const itemVariants = {
  hidden: { opacity: 0, y: 20 },
  visible: { 
    opacity: 1, 
    y: 0,
    transition: { type: "spring", stiffness: 350, damping: 25 }
  }
}

export function AnimatedList({ items }: { items: string[] }) {
  return (
    <motion.ul variants={containerVariants} initial="hidden" animate="visible">
      {items.map((item, idx) => (
        <motion.li key={idx} variants={itemVariants}>
          {item}
        </motion.li>
      ))}
    </motion.ul>
  )
}
```

### C. Gestures (Hover, Tap, Drag)
```tsx
<motion.button
  whileHover={{ scale: 1.03, y: -2 }}
  whileTap={{ scale: 0.97 }}
  transition={{ type: "spring", stiffness: 400, damping: 17 }}
  className="px-6 py-3 bg-indigo-600 text-white rounded-xl shadow-lg"
>
  Click Me
</motion.button>
```

### D. AnimatePresence (Mount / Unmount & Page Transitions)
```tsx
<AnimatePresence mode="wait">
  {isOpen && (
    <motion.div
      key="modal-backdrop"
      initial={{ opacity: 0 }}
      animate={{ opacity: 1 }}
      exit={{ opacity: 0 }}
      className="fixed inset-0 bg-black/50 backdrop-blur-sm z-50"
    >
      <motion.div
        key="modal-card"
        initial={{ opacity: 0, scale: 0.95, y: 20 }}
        animate={{ opacity: 1, scale: 1, y: 0 }}
        exit={{ opacity: 0, scale: 0.95, y: 20 }}
        transition={{ type: "spring", stiffness: 350, damping: 25 }}
        className="bg-white dark:bg-zinc-900 p-6 rounded-2xl shadow-2xl"
      >
        <h3>Modal Content</h3>
      </motion.div>
    </motion.div>
  )}
</AnimatePresence>
```

### E. Shared Element Transition (`layoutId`)
```tsx
// Active tab indicator
{tabs.map(tab => (
  <button key={tab.id} onClick={() => setSelected(tab.id)} className="relative px-4 py-2">
    {tab.label}
    {selected === tab.id && (
      <motion.div
        layoutId="active-indicator"
        className="absolute inset-0 bg-blue-500/10 rounded-lg -z-10 border border-blue-500/30"
        transition={{ type: "spring", stiffness: 380, damping: 30 }}
      />
    )}
  </button>
))}
```

### F. Scroll-Driven & Parallax Animations
```tsx
export function ScrollProgressHero() {
  const { scrollYProgress } = useScroll()
  const scale = useTransform(scrollYProgress, [0, 0.5], [1, 0.85])
  const opacity = useTransform(scrollYProgress, [0, 0.4], [1, 0])
  const smoothY = useSpring(useTransform(scrollYProgress, [0, 1], [0, -100]), { stiffness: 100, damping: 30 })

  return (
    <motion.div style={{ scale, opacity, y: smoothY }} className="hero-container">
      <h1>Dynamic Hero</h1>
    </motion.div>
  )
}
```

---

## 4. Presets & Physics Recipes

| Recipe | Transition Config | Best For |
|---|---|---|
| **Snappy Spring** | `{ type: "spring", stiffness: 400, damping: 25 }` | Buttons, toggles, micro-interactions |
| **Gentle Spring** | `{ type: "spring", stiffness: 180, damping: 20 }` | Cards, modals, sheet dialogs |
| **Bouncy Pop** | `{ type: "spring", stiffness: 500, damping: 15 }` | Badges, success checkmarks, likes |
| **Smooth Ease** | `{ duration: 0.35, ease: [0.16, 1, 0.3, 1] }` | Fade reveals, subtle banners |
| **Slow Cinematic** | `{ duration: 0.8, ease: [0.25, 0.1, 0.25, 1] }` | Hero section entries, background transitions |

---

## 5. References & Templates

- **Reference Documentation**:
  - [API Reference](./reference/api-reference.md)
  - [Spring Physics Guide](./reference/spring-physics.md)
- **Production Examples**:
  - [Card Hover Effects](./examples/card-hover.md)
  - [Hero Fade Up](./examples/hero-fade-up.md)
  - [Magnetic Button](./examples/magnetic-button.md)
  - [Parallax Layers](./examples/parallax-layers.md)
  - [Scroll Reveal](./examples/scroll-reveal.md)
- **Ready-to-use Templates**:
  - [Component Library](./templates/component-library.tsx)
  - [Next.js Animated Page](./templates/nextjs-page.tsx)
