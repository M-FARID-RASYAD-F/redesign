"use client";

import * as React from "react";
import { AnimatePresence, motion } from "framer-motion";
import { useOnClickOutside } from "usehooks-ts";
import { cn } from "@/lib/utils";
import { Home, GraduationCap, Building2, Newspaper, FileText, LucideIcon } from "lucide-react";

export interface NavTab {
  title: string;
  href?: string;
  icon: LucideIcon;
  type?: never;
}

export interface NavSeparator {
  type: "separator";
  title?: never;
  icon?: never;
  href?: never;
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
  { title: "Beranda", href: "#beranda", icon: Home },
  { title: "Jenjang", href: "#jenjang", icon: GraduationCap },
  { title: "Cabang", href: "#cabang", icon: Building2 },
  { title: "Berita", href: "#berita", icon: Newspaper },
  { type: "separator" },
  { title: "PPDB Online", href: "/ppdb", icon: FileText },
];

const buttonVariants = {
  initial: {
    gap: 0,
    paddingLeft: ".6rem",
    paddingRight: ".6rem",
  },
  animate: (isSelected: boolean) => ({
    gap: isSelected ? ".55rem" : 0,
    paddingLeft: isSelected ? "1rem" : ".6rem",
    paddingRight: isSelected ? "1rem" : ".6rem",
  }),
};

const spanVariants = {
  initial: { width: 0, opacity: 0 },
  animate: { width: "auto", opacity: 1 },
  exit: { width: 0, opacity: 0 },
};

const transition = { delay: 0.05, type: "spring", bounce: 0, duration: 0.5 };

export function MainNavigationTabs({
  tabs = defaultHomeNavTabs,
  className,
  activeColor = "text-[#00B4D8] dark:text-[#38bdf8]",
  initialSelected = 0,
  onNavigate,
}: MainNavigationTabsProps) {
  const [selected, setSelected] = React.useState<number | null>(initialSelected);
  const outsideClickRef = React.useRef<HTMLDivElement>(null);

  useOnClickOutside(outsideClickRef as any, () => {
    // Tetap pertahankan tab aktif yang terakhir dipilih pengguna
  });

  const handleSelect = (item: NavTab, index: number) => {
    setSelected(index);
    if (onNavigate) {
      onNavigate(item, index);
    } else if (item.href) {
      if (item.href.startsWith("#")) {
        const el = document.querySelector(item.href);
        if (el) {
          el.scrollIntoView({ behavior: "smooth" });
        }
      } else {
        window.location.href = item.href;
      }
    }
  };

  const Separator = () => (
    <div className="mx-1 h-[22px] w-[1.2px] bg-white/15 dark:bg-white/15" aria-hidden="true" />
  );

  return (
    <div
      ref={outsideClickRef}
      className={cn(
        "inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-[#001529]/80 dark:bg-[#001529]/80 backdrop-blur-xl p-1 shadow-lg shadow-black/20",
        className
      )}
    >
      {tabs.map((tab, index) => {
        if (tab.type === "separator") {
          return <Separator key={`separator-${index}`} />;
        }

        const Icon = tab.icon;
        const isSelected = selected === index;

        return (
          <motion.button
            key={tab.title}
            type="button"
            variants={buttonVariants}
            initial={false}
            animate="animate"
            custom={isSelected}
            onClick={() => handleSelect(tab, index)}
            transition={transition}
            className={cn(
              "relative flex items-center rounded-full py-1.5 text-xs md:text-sm font-bold transition-colors duration-250 cursor-pointer",
              isSelected
                ? cn("bg-white/10 dark:bg-white/10 shadow-sm", activeColor)
                : "text-slate-300 hover:bg-white/5 hover:text-white"
            )}
          >
            <Icon size={18} className="shrink-0" />
            <AnimatePresence initial={false}>
              {isSelected && (
                <motion.span
                  variants={spanVariants}
                  initial="initial"
                  animate="animate"
                  exit="exit"
                  transition={transition}
                  className="overflow-hidden whitespace-nowrap"
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
