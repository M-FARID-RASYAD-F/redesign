"use client";

import * as React from "react";
import { AnimatePresence, motion } from "framer-motion";
import { useOnClickOutside } from "usehooks-ts";
import { cn } from "@/lib/utils";
import { Home, GraduationCap, Building2, Newspaper, FileText, LucideIcon } from "lucide-react";

export interface NavTab {
  title: string;
  href: string;
  sectionId?: string;
  icon: LucideIcon;
  type?: never;
}

export interface NavSeparator {
  type: "separator";
  title?: never;
  icon?: never;
  href?: never;
  sectionId?: never;
}

export type MainNavTabItem = NavTab | NavSeparator;

export interface MainNavigationTabsProps {
  tabs?: MainNavTabItem[];
  className?: string;
  activeColor?: string;
  initialSelected?: number;
  onNavigate?: (item: NavTab, index: number) => void;
}

export const defaultHomeNavTabs: MainNavTabItem[] = [
  { title: "Beranda", href: "#beranda", sectionId: "beranda", icon: Home },
  { title: "Jenjang", href: "#jenjang", sectionId: "jenjang", icon: GraduationCap },
  { title: "Cabang", href: "#cabang", sectionId: "cabang", icon: Building2 },
  { title: "Berita", href: "#berita", sectionId: "berita", icon: Newspaper },
  { type: "separator" },
  { title: "PPDB Online", href: "/ppdb", icon: FileText },
];

const buttonVariants = {
  initial: {
    gap: 0,
    paddingLeft: ".55rem",
    paddingRight: ".55rem",
  },
  animate: (isExpanded: boolean) => ({
    gap: isExpanded ? ".5rem" : 0,
    paddingLeft: isExpanded ? ".9rem" : ".55rem",
    paddingRight: isExpanded ? ".9rem" : ".55rem",
  }),
};

const spanVariants = {
  initial: { width: 0, opacity: 0 },
  animate: { width: "auto", opacity: 1 },
  exit: { width: 0, opacity: 0 },
};

const transition = { delay: 0.04, type: "spring", bounce: 0.15, duration: 0.45 };

export function MainNavigationTabs({
  tabs = defaultHomeNavTabs,
  className,
  activeColor = "text-[#00B4D8] dark:text-[#38bdf8]",
  initialSelected = 0,
  onNavigate,
}: MainNavigationTabsProps) {
  const [selected, setSelected] = React.useState<number | null>(initialSelected);
  const [hovered, setHovered] = React.useState<number | null>(null);
  const outsideClickRef = React.useRef<HTMLDivElement>(null);

  // Initial detection from URL
  React.useEffect(() => {
    if (typeof window === "undefined") return;

    if (window.location.pathname.startsWith("/ppdb")) {
      setSelected(5);
      return;
    }

    if (window.location.hash) {
      const hash = window.location.hash;
      const foundIdx = tabs.findIndex(t => t.type !== "separator" && t.href === hash);
      if (foundIdx !== -1) {
        setSelected(foundIdx);
      }
    }
  }, [tabs]);

  // Auto detect active section based on scroll position on the landing page
  React.useEffect(() => {
    if (typeof window === "undefined") return;

    const onScroll = () => {
      const isHomePage = window.location.pathname === "/" || window.location.pathname === "";
      if (!isHomePage) {
        if (window.location.pathname.startsWith("/ppdb")) {
          setSelected(5);
        }
        return;
      }

      const scrollY = window.scrollY;
      const navHeight = 90;

      const jenjangEl = document.getElementById("jenjang") || document.getElementById("jurusan");
      const cabangEl  = document.getElementById("cabang")  || document.getElementById("fasilitas");
      const beritaEl  = document.getElementById("berita");

      const jenjangTop = jenjangEl ? (jenjangEl.getBoundingClientRect().top + scrollY - navHeight) : 1200;
      const cabangTop  = cabangEl  ? (cabangEl.getBoundingClientRect().top + scrollY - navHeight)  : 2200;
      const beritaTop  = beritaEl  ? (beritaEl.getBoundingClientRect().top + scrollY - navHeight)  : 3200;

      if (scrollY < jenjangTop - 80) {
        setSelected(0);
      } else if (scrollY >= jenjangTop - 80 && scrollY < cabangTop - 80) {
        setSelected(1);
      } else if (scrollY >= cabangTop - 80 && scrollY < beritaTop - 80) {
        setSelected(2);
      } else {
        setSelected(3);
      }
    };

    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();

    return () => window.removeEventListener("scroll", onScroll);
  }, [tabs]);

  useOnClickOutside(outsideClickRef as any, () => {
    // Keep active selection intact
  });

  const handleSelect = (item: NavTab, index: number) => {
    setSelected(index);

    if (onNavigate) {
      onNavigate(item, index);
      return;
    }

    if (item.href) {
      if (item.href.startsWith("#")) {
        const isHomePage = window.location.pathname === "/" || window.location.pathname === "";
        if (isHomePage) {
          const targetEl = document.querySelector(item.href);
          if (targetEl) {
            const navHeight = 78;
            const targetPos = item.href === "#beranda" ? 0 : targetEl.getBoundingClientRect().top + window.pageYOffset - navHeight;
            window.scrollTo({ top: targetPos, behavior: "smooth" });
            history.pushState(null, "", item.href);
          }
        } else {
          window.location.href = "/" + item.href;
        }
      } else {
        window.location.href = item.href;
      }
    }
  };

  return (
    <div
      ref={outsideClickRef}
      className={cn("expandable-nav-tabs", className)}
    >
      {tabs.map((tab, index) => {
        if (tab.type === "separator") {
          return <div key={`separator-${index}`} className="expandable-tab-separator" aria-hidden="true" />;
        }

        const Icon = tab.icon;
        const isSelected = selected === index;
        const isExpanded = isSelected || hovered === index;

        return (
          <motion.button
            key={tab.title}
            type="button"
            variants={buttonVariants}
            initial={false}
            animate="animate"
            custom={isExpanded}
            onClick={() => handleSelect(tab, index)}
            onMouseEnter={() => setHovered(index)}
            onMouseLeave={() => setHovered(null)}
            transition={transition}
            className={cn(
              "expandable-tab-btn",
              isSelected && "active"
            )}
            aria-label={tab.title}
          >
            <Icon size={18} className="tab-icon shrink-0" />
            <AnimatePresence initial={false}>
              {isExpanded && (
                <motion.span
                  variants={spanVariants}
                  initial="initial"
                  animate="animate"
                  exit="exit"
                  transition={transition}
                  className="tab-label overflow-hidden whitespace-nowrap"
                  style={{ maxWidth: "none", opacity: 1 }}
                >
                  {tab.title}
                </motion.span>
              )}
            </AnimatePresence>
          </motion.button>
        );
      })}
    </div>
  );
}
