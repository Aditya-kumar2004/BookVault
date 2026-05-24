import { useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useAuthStore } from "@/stores";
import { toast } from "sonner";

export default function GoogleCallback() {
  const navigate = useNavigate();
  const setAuth = useAuthStore((s) => s.setAuth);

  useEffect(() => {
    const params = new URLSearchParams(window.location.search);
    const token = params.get("token");
    const userRaw = params.get("user");
    const error = params.get("error");

    if (error || !token || !userRaw) {
      toast.error("Google login failed");
      navigate("/login");
      return;
    }

    try {
      const user = JSON.parse(decodeURIComponent(userRaw));
      setAuth(user, token);
      toast.success("Welcome, " + user.name + "!");
      navigate(user.role === "admin" ? "/admin" : "/dashboard");
    } catch {
      toast.error("Google login failed");
      navigate("/login");
    }
  }, []);

  return (
    <div className="min-h-screen flex items-center justify-center">
      <p className="text-muted-foreground text-lg">Signing you in with Google...</p>
    </div>
  );
}
