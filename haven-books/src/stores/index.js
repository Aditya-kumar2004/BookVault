import { create } from "zustand";
import { persist } from "zustand/middleware";
import api from "../lib/api";

export const useAuthStore = create()(
  persist(
    (set, get) => ({
      user: null,
      token: null,
      isAdmin: () => get().user?.role === "admin",
      login: async (email, password) => {
        const { data } = await api.post("/login", { email, password });
        set({ user: data.user, token: data.token });
        return data.user;
      },
      register: async (name, email, password) => {
        const { data } = await api.post("/register", { name, email, password });
        set({ user: data.user, token: data.token });
        return data.user;
      },
      logout: async () => {
        try { await api.post("/logout"); } catch (_) {}
        set({ user: null, token: null });
      },
      setAuth: (user, token) => set({ user, token }),
    }),
    { name: "bookvault-auth" }
  )
);

export const useCartStore = create()(
  persist(
    (set, get) => ({
      items: [],
      add: (book) =>
        set((s) => {
          const found = s.items.find((i) => i.book.id === book.id);
          if (found) return { items: s.items.map((i) => i.book.id === book.id ? { ...i, qty: i.qty + 1 } : i) };
          return { items: [...s.items, { book, qty: 1 }] };
        }),
      remove: (id) => set((s) => ({ items: s.items.filter((i) => i.book.id !== id) })),
      clear: () => set({ items: [] }),
      setQty: (id, qty) =>
        set((s) => ({ items: s.items.map((i) => i.book.id === id ? { ...i, qty: Math.max(1, qty) } : i) })),
      total: () => get().items.reduce((sum, i) => sum + i.book.price * i.qty, 0),
      count: () => get().items.reduce((sum, i) => sum + i.qty, 0),
      checkout: async (shippingAddress = "Default Address") => {
        await api.post("/orders", { 
          shipping_address: shippingAddress,
          items: get().items
        });
        set({ items: [] });
      },
    }),
    { name: "bookvault-cart" }
  )
);

export const useWishlistStore = create()(
  persist(
    (set, get) => ({
      ids: [],
      toggle: (id) =>
        set((s) => ({ ids: s.ids.includes(id) ? s.ids.filter((x) => x !== id) : [...s.ids, id] })),
      has: (id) => get().ids.includes(id),
      clear: () => set({ ids: [] }),
    }),
    { name: "bookvault-wishlist" }
  )
);
