import { NavLink, Outlet, useNavigate, Navigate } from "react-router-dom";
import {
  LayoutDashboard, BookOpen, Heart, ShoppingBag, Star, Settings, LogOut, ShoppingCart,
} from "lucide-react";
import { useAuthStore, useCartStore } from "@/stores";
import { cn } from "@/lib/utils";
import { toast } from "sonner";

const items = [
  { to: "/dashboard", label: "Dashboard", icon: LayoutDashboard, end: true },
  { to: "/dashboard/library", label: "My Library", icon: BookOpen },
  { to: "/dashboard/wishlist", label: "Wishlist", icon: Heart },
  { to: "/dashboard/orders", label: "Orders", icon: ShoppingBag },
  { to: "/dashboard/reviews", label: "Reviews", icon: Star },
  { to: "/dashboard/settings", label: "Settings", icon: Settings },
];

export default function DashboardLayout() {
  const { user, logout } = useAuthStore();
  const cartCount = useCartStore((s) => s.count());
  const nav = useNavigate();
  if (!user) return <Navigate to="/login" replace />;

  return (
    <div className="min-h-screen flex bg-background">
      <aside className="w-64 bg-sidebar text-sidebar-foreground hidden md:flex flex-col">
        <div className="p-6">
          <NavLink to="/" className="font-display text-xl font-bold">📖 BookVault</NavLink>
        </div>
        <nav className="flex-1 px-3 space-y-1">
          {items.map((it) => (
            <NavLink
              key={it.to}
              to={it.to}
              end={it.end}
              className={({ isActive }) =>
                cn(
                  "flex items-center gap-3 px-3 py-2.5 rounded-md text-sm transition",
                  isActive ? "bg-sidebar-accent text-sidebar-accent-foreground" : "hover:bg-sidebar-accent/50"
                )
              }
            >
              <it.icon className="h-4 w-4" /> {it.label}
            </NavLink>
          ))}
          <NavLink
            to="/cart"
            className={({ isActive }) =>
              cn(
                "flex items-center justify-between px-3 py-2.5 rounded-md text-sm transition",
                isActive ? "bg-sidebar-accent text-sidebar-accent-foreground" : "hover:bg-sidebar-accent/50"
              )
            }
          >
            <div className="flex items-center gap-3">
              <ShoppingCart className="h-4 w-4" /> Shopping Cart
            </div>
            {cartCount > 0 && (
              <span className="bg-accent text-white text-[10px] font-bold rounded-full px-2 py-0.5 shadow-sm shrink-0">
                {cartCount}
              </span>
            )}
          </NavLink>
          <button
            onClick={() => { logout(); toast.success("Signed out"); nav("/"); }}
            className="w-full flex items-center gap-3 px-3 py-2.5 rounded-md text-sm hover:bg-sidebar-accent/50 transition"
          >
            <LogOut className="h-4 w-4" /> Logout
          </button>
        </nav>
        <div className="p-4 border-t border-sidebar-border flex items-center gap-3">
          <div className="h-10 w-10 rounded-full bg-accent flex items-center justify-center text-accent-foreground font-bold">
            {user.name[0]?.toUpperCase()}
          </div>
          <div className="text-sm">
            <div className="font-medium">{user.name}</div>
            <div className="text-xs opacity-70">{user.email}</div>
          </div>
        </div>
      </aside>

      <main className="flex-1 p-6 md:p-10 overflow-auto">
        <Outlet />
      </main>
    </div>
  );
}
