import { useState } from "react";
import { NavLink, Outlet, useNavigate, Navigate } from "react-router-dom";
import {
  LayoutDashboard, BookOpen, Users, Tags, Boxes, ShoppingBag,
  UserCog, MessageSquare, Activity, Ticket, Settings, LogOut, Menu
} from "lucide-react";
import { useAuthStore } from "@/stores";
import { cn } from "@/lib/utils";
import { toast } from "sonner";
import { Sheet, SheetContent, SheetTrigger } from "@/components/ui/sheet";
import { Button } from "@/components/ui/button";

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
  const [open, setOpen] = useState(false);

  if (!user) return <Navigate to="/login" replace />;
  if (user.role !== "admin")
    return (
      <div className="min-h-screen flex flex-col items-center justify-center text-center p-6">
        <h1 className="font-display text-3xl font-bold">Admin access required</h1>
        <p className="text-muted-foreground mt-2">Sign up with role "Admin" to access this panel.</p>
      </div>
    );

  const NavigationContent = ({ mobile = false }) => (
    <nav className="flex-1 px-3 space-y-0.5 overflow-y-auto">
      {items.map((it) => (
        <NavLink
          key={it.to}
          to={it.to}
          end={it.end}
          onClick={() => mobile && setOpen(false)}
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
        className="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm hover:bg-white/10 transition mt-2 text-left"
      >
        <LogOut className="h-4 w-4" /> Logout
      </button>
    </nav>
  );

  return (
    <div className="min-h-screen flex flex-col md:flex-row bg-background">
      {/* Mobile Header */}
      <header className="flex md:hidden items-center justify-between px-6 py-4 border-b bg-navy text-white">
        <NavLink to="/" className="font-display text-xl font-bold">📖 Admin</NavLink>
        <Sheet open={open} onOpenChange={setOpen}>
          <SheetTrigger asChild>
            <Button variant="ghost" size="icon" className="h-9 w-9 hover:bg-white/10 hover:text-white text-white">
              <Menu className="h-5 w-5" />
            </Button>
          </SheetTrigger>
          <SheetContent side="left" className="w-64 p-0 bg-navy text-navy-foreground flex flex-col border-none">
            <div className="p-6 border-b border-white/10">
              <NavLink to="/" onClick={() => setOpen(false)} className="font-display text-xl font-bold text-white">📖 Admin</NavLink>
            </div>
            <div className="flex-1 py-4 overflow-y-auto">
              <NavigationContent mobile />
            </div>
            <div className="p-4 border-t border-white/10 text-xs text-white">
              <div className="font-medium truncate">{user.name}</div>
              <div className="opacity-70 truncate">{user.email}</div>
            </div>
          </SheetContent>
        </Sheet>
      </header>

      {/* Desktop Sidebar */}
      <aside className="w-64 bg-navy text-navy-foreground hidden md:flex flex-col">
        <div className="p-6">
          <NavLink to="/" className="font-display text-xl font-bold text-white">📖 Admin</NavLink>
        </div>
        <NavigationContent />
        <div className="p-4 border-t border-white/10 text-xs text-white">
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
