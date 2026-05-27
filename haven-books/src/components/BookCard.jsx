import { useState } from "react";
import { Star, Heart, ShoppingCart, Trash2 } from "lucide-react";
import { Link, useNavigate } from "react-router-dom";
import { coverFromIsbn } from "@/data/books";
import { cn } from "@/lib/utils";
import { useCartStore, useWishlistStore, useAuthStore } from "@/stores";
import { toast } from "sonner";

const BACKEND_URL = import.meta.env.VITE_API_URL || "http://127.0.0.1:8000";

const initials = (title) =>
  title.split(" ").map((w) => w[0]).slice(0, 2).join("").toUpperCase();

export function BookCover({ book, className }) {
  const [errored, setErrored] = useState(false);

  let coverUrl = coverFromIsbn(book.isbn);
  if (book.cover_image) {
    if (book.cover_image.startsWith("http") || book.cover_image.startsWith("data:")) {
      coverUrl = book.cover_image;
    } else {
      const path = book.cover_image.startsWith("/") ? book.cover_image : `/${book.cover_image}`;
      coverUrl = `${BACKEND_URL}${path}`;
    }
  }

  return (
    <div className={cn("book-cover relative", className)}>
      {!errored ? (
        <img
          src={coverUrl}
          alt={`${book.title} cover`}
          loading="lazy"
          decoding="async"
          onError={() => setErrored(true)}
          className="h-full w-full object-cover"
          style={{ willChange: "transform" }}
        />
      ) : (
        <div className="h-full w-full bg-gradient-to-br from-primary to-primary-glow flex items-center justify-center">
          <span className="font-display text-3xl text-primary-foreground">{initials(book.title)}</span>
        </div>
      )}
    </div>
  );
}


export function BookCard({ book, showBestsellerBadge = false, isWishlist = false }) {
  const navigate = useNavigate();
  const user = useAuthStore((s) => s.user);
  const addToCart = useCartStore((s) => s.add);
  const toggleWish = useWishlistStore((s) => s.toggle);
  const isWished = useWishlistStore((s) => s.has(book.id));
  const price = parseFloat(book.price);
  const oldPrice = book.original_price ? parseFloat(book.original_price) : (book.oldPrice ? parseFloat(book.oldPrice) : null);
  const reviewsCount = book.reviews ?? 0;
  const discount = book.discount ?? (oldPrice
    ? Math.round(((oldPrice - price) / oldPrice) * 100)
    : null);

  const isBestseller = book.badge === "BESTSELLER" || book.is_featured || showBestsellerBadge;

  return (
    /* Pure CSS hover lift — no JS spring = no layout thrashing */
    <div
      className="group relative flex flex-col w-full"
      style={{
        transform: "translateZ(0)",           /* GPU layer */
        transition: "transform 0.25s ease",
        willChange: "transform",
      }}
      onMouseEnter={(e) => (e.currentTarget.style.transform = "translateY(-5px) translateZ(0)")}
      onMouseLeave={(e) => (e.currentTarget.style.transform = "translateZ(0)")}
    >
      {/* Cover */}
      <Link to={`/books/${book.id}`} className="block">
        <div className="relative overflow-hidden rounded-2xl shadow-book">

          {/* Stacked badges top-left */}
          <div className="absolute top-2 left-2 z-10 flex flex-col gap-0.5">
            {discount && (
              <span className="bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full leading-none">
                -{discount}%
              </span>
            )}
            {isBestseller && (
              <span className="bg-red-500 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full leading-none">
                SELLER
              </span>
            )}
          </div>

          {/* NYT Bestseller label */}
          {book.nytBestseller && (
            <div className="absolute top-2 left-0 right-0 z-10 flex justify-center pointer-events-none">
              <span className="text-[9px] font-semibold text-white/90 bg-black/40 px-2 py-0.5 rounded-full">
                #1 NEW YORK TIMES BESTSELLER
              </span>
            </div>
          )}

          {/* Wishlist — no backdrop-filter for perf */}
          <button
            onClick={(e) => {
              e.preventDefault();
              if (!user) {
                toast.error("Please login to add books to your wishlist!");
                navigate("/login");
                return;
              }
              if (isWishlist) {
                toggleWish(book.id);
                toast.success("Removed from wishlist");
              } else {
                if (isWished) {
                  toast.success("Book has been already added", {
                    style: {
                      border: "1px solid #10B981",
                      background: "#ECFDF5",
                      color: "#065F46"
                    }
                  });
                } else {
                  toggleWish(book.id);
                  toast.success("Added to wishlist");
                }
              }
            }}
            aria-label={isWishlist ? "Remove from wishlist" : "Toggle wishlist"}
            className="absolute top-2 right-2 z-10 h-7 w-7 rounded-full bg-white/90 flex items-center justify-center shadow hover:scale-110 transition-transform duration-200"
          >
            {isWishlist ? (
              <Trash2 className="h-3.5 w-3.5 text-red-500 hover:text-red-600" />
            ) : (
              <Heart className={cn("h-3.5 w-3.5", isWished ? "fill-accent text-accent" : "text-gray-400")} />
            )}
          </button>

          {/* Book Cover Image — CSS scale only, no JS */}
          <BookCover
            book={book}
            className="w-full"
            style={{ transition: "transform 0.4s ease", willChange: "transform" }}
          />
          {/* Hover scale via CSS on the img inside .group */}
          <style>{`.group:hover .book-cover img { transform: scale(1.04); }`}</style>

          {/* Add to cart slide-up on hover — CSS only (hidden on mobile, shown on desktop) */}
          <div className="absolute inset-x-0 bottom-0 translate-y-full group-hover:translate-y-0 transition-transform duration-250 p-2 hidden md:block">
            <button
              onClick={(e) => {
                e.preventDefault();
                if (!user) {
                  toast.error("Please login to add items to your cart!");
                  navigate("/login");
                  return;
                }
                addToCart(book);
                toast.success(`Added "${book.title}" to cart`);
              }}
              className="w-full py-2 rounded-xl bg-accent text-white text-xs font-bold flex items-center justify-center gap-1.5 shadow-lg"
            >
              <ShoppingCart className="h-3.5 w-3.5" /> Add to Cart
            </button>
          </div>
        </div>
      </Link>

      {/* Info below cover */}
      <div className="pt-2.5 space-y-1 flex flex-col flex-1">
        <h3 className="font-display font-bold text-sm leading-snug line-clamp-1">{book.title}</h3>
        <p className="text-xs text-muted-foreground line-clamp-1">{book.author}</p>
        <div className="flex items-center gap-0.5 text-xs">
          {[...Array(5)].map((_, i) => (
            <Star key={i} className={cn("h-3 w-3", i < Math.round(book.rating) ? "fill-amber-400 text-amber-400" : "fill-muted text-muted")} />
          ))}
          <span className="text-muted-foreground ml-1 text-[10px]">({reviewsCount.toLocaleString()})</span>
        </div>
        <div className="flex items-center gap-2 pt-0.5">
          <span className="font-bold text-accent text-sm">₹{price.toFixed(2)}</span>
          {oldPrice && (
            <span className="text-xs text-muted-foreground line-through">₹{oldPrice.toFixed(2)}</span>
          )}
        </div>

        {/* Static Add to Cart button — visible on mobile, hidden on desktop to prevent duplication */}
        <button
          onClick={() => {
            if (!user) {
              toast.error("Please login to add items to your cart!");
              navigate("/login");
              return;
            }
            addToCart(book);
            toast.success(`Added "${book.title}" to cart`);
          }}
          className="mt-2 w-full py-1.5 rounded-xl border border-accent/30 hover:bg-accent hover:text-white text-accent text-xs font-semibold transition-colors duration-200 flex items-center justify-center gap-1 md:hidden"
          style={{ backgroundColor: "rgba(244,98,58,0.08)" }}
        >
          <ShoppingCart className="h-3.5 w-3.5" />
          <span>Add to Cart</span>
        </button>
      </div>
    </div>
  );
}
