import { NavLink, Outlet, useNavigate, Navigate } from "react-router-dom";
import {
  LayoutDashboard, BookOpen, Users, Tags, Boxes, ShoppingBag,
  UserCog, MessageSquare, Activity, Ticket, Settings, LogOut,
} from "lucide-react";
import { useAuthStore } from "@/stores";
import { cn } from "@/lib/utils";
import { toast } from "sonner";

const items = [
  { to: "/admin", label: "Overview", icon: LayoutDashboard, end: true },
  { to: "/admin/books", label: "Books", icon: BookOpen },
  { to: "/admin/authors", label: "Authors", icon: Users },
  { to: "/admin/genres", label: "Genres", icon: Tags },
  { to: "/admin/inventory", label: "Inventory", icon: Boxes },
  { to: "/admin/orders", label: "Orders", icon: ShoppingBag },
  { to: "/admin/users", label: "Users", icon: UserCog },
  { to: "/admin/reviews", label: "Reviews", icon: MessageSquare },
  { to: "/admin/activity", label: "Activity", icon: Activity },
  { to: "/admin/coupons", label: "Coupons", icon: Ticket },
  { to: "/admin/settings", label: "Settings", icon: Settings },
];

export default function AdminLayout() {
  const { user, logout } = useAuthStore();
  const nav = useNavigate();

  if (!user) return <Navigate to="/login" replace />;
  if (user.role !== "admin")
    return (
      <div className="min-h-screen flex flex-col items-center justify-center text-center p-6">
        <h1 className="font-display text-3xl font-bold">Admin access required</h1>
        <p className="text-muted-foreground mt-2">Sign up with role "Admin" to access this panel.</p>
      </div>
    );

  return (
    <div className="min-h-screen flex bg-background">
      <aside className="w-64 bg-navy text-navy-foreground hidden md:flex flex-col">
        <div className="p-6">
          <NavLink to="/" className="font-display text-xl font-bold">📖 Admin</NavLink>
        </div>
        <nav className="flex-1 px-3 space-y-0.5 overflow-y-auto">
          {items.map((it) => (
            <NavLink
              key={it.to}
              to={it.to}
              end={it.end}
              className={({ isActive }) =>
                cn(
                  "flex items-center gap-3 px-3 py-2 rounded-md text-sm transition",
                  isActive ? "bg-accent text-accent-foreground" : "hover:bg-white/10"
                )
              }
            >
              <it.icon className="h-4 w-4" /> {it.label}
            </NavLink>
          ))}
          <button
            onClick={() => { logout(); toast.success("Signed out"); nav("/"); }}
            className="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm hover:bg-white/10 transition mt-2"
          >
            <LogOut className="h-4 w-4" /> Logout
          </button>
        </nav>
        <div className="p-4 border-t border-white/10 text-xs">
          <div className="font-medium">{user.name}</div>
          <div className="opacity-70">{user.email}</div>
        </div>
      </aside>
      <main className="flex-1 p-6 md:p-10 overflow-auto">
        <Outlet />
      </main>
    </div>
  );
}
