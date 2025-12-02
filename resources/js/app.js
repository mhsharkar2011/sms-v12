import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Live Date and Time Component
class LiveDateTime {
    constructor() {
        this.timeElement = document.getElementById("live-clock");
        this.dateElement = document.getElementById("live-date");
        this.start();
    }

    update() {
        const now = new Date();

        // Time formatting
        const time = now.toLocaleTimeString("en-US", {
            hour: "numeric",
            minute: "2-digit",
            second: "2-digit",
            hour12: true,
        });

        // Date formatting
        const date = now.toLocaleDateString("en-US", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });

        this.timeElement.textContent = time;
        this.dateElement.textContent = date;
    }

    start() {
        this.update();
        setInterval(() => this.update(), 1000);
    }
}

// Initialize when document is loaded
document.addEventListener("DOMContentLoaded", () => {
    new LiveDateTime();
});
// =============================================================

// Like Button Functionality====================================
async function toggleLike(postId) {
    console.log("Attempting to like post:", postId);

    // Get CSRF token
    const csrfToken = document.querySelector(
        'meta[name="csrf-token"]'
    )?.content;

    if (!csrfToken) {
        console.error("CSRF token not found");
        return;
    }

    const likeButton = document.getElementById(`like-button-${postId}`);
    const likeIcon = document.getElementById(`like-icon-${postId}`);
    const likeText = document.getElementById(`like-text-${postId}`);
    const likeCount = document.getElementById(`like-count-${postId}`);

    if (!likeButton || !likeIcon || !likeText || !likeCount) {
        console.error("Like elements not found");
        return;
    }

    try {
        // Disable button during request
        likeButton.disabled = true;

        console.log(
            "Sending request with CSRF token:",
            csrfToken.substring(0, 20) + "..."
        );

        // Make the request WITH credentials
        const response = await fetch(`/posts/${postId}/toggle-like`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
            },
            credentials: "include", // ← THIS IS THE KEY
        });

        console.log("Response status:", response.status);
        console.log(
            "Response headers:",
            Object.fromEntries(response.headers.entries())
        );

        // Check if unauthorized
        if (response.status === 401 || response.status === 419) {
            console.log("Authentication required, redirecting to login...");
            window.location.href = "/login";
            return;
        }

        // Check if method not allowed
        if (response.status === 405) {
            console.error("Method not allowed. Is the route defined as POST?");
            alert(
                "Like feature is currently unavailable. Please try again later."
            );
            return;
        }

        // Check if not found
        if (response.status === 404) {
            console.error("Route not found:", `/posts/${postId}/toggle-like`);

            // Try alternative route
            const altResponse = await fetch(`/like-post/${postId}`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                credentials: "include",
            });

            if (altResponse.ok) {
                const data = await altResponse.json();
                console.log("Success via alternative route:", data);
                updateUILike(data, likeIcon, likeText, likeCount, likeButton);
                return;
            }

            return;
        }

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log("Response data:", data);

        // Update UI
        updateUILike(data, likeIcon, likeText, likeCount, likeButton);
    } catch (error) {
        console.error("Error toggling like:", error);

        // Show error temporarily
        const originalText = likeText.textContent;
        const originalIcon = likeIcon.textContent;

        likeText.textContent = "Error";
        likeIcon.textContent = "⚠️";
        likeButton.classList.add("text-red-500");

        setTimeout(() => {
            likeText.textContent = originalText;
            likeIcon.textContent = originalIcon;
            likeButton.classList.remove("text-red-500");
        }, 2000);
    } finally {
        likeButton.disabled = false;
    }
}

function updateUILike(data, likeIcon, likeText, likeCount, likeButton) {
    if (data.is_liked) {
        likeIcon.textContent = "❤️";
        likeText.textContent = "Liked";
        likeButton.classList.remove("text-blue-600", "hover:text-blue-800");
        likeButton.classList.add("text-pink-600", "hover:text-pink-800");
        likeButton.setAttribute("aria-label", "Unlike this post");
    } else {
        likeIcon.textContent = "🤍";
        likeText.textContent = "Like";
        likeButton.classList.remove("text-pink-600", "hover:text-pink-800");
        likeButton.classList.add("text-blue-600", "hover:text-blue-800");
        likeButton.setAttribute("aria-label", "Like this post");
    }

    if (data.likes_count !== undefined) {
        likeCount.textContent = `${data.likes_count} Likes`;
    }

    // Animation
    likeIcon.style.transform = "scale(1.3)";
    setTimeout(() => {
        likeIcon.style.transform = "scale(1)";
    }, 200);
}



async function toggleLike(e, postId) {
    const button = e.currentTarget;
    const likeIcon = document.getElementById(`like-icon-${postId}`);
    const likeText = document.getElementById(`like-text-${postId}`);
    const likeCount = document.getElementById(`like-count-${postId}`);
}

// Initialize when document is loaded


async function toggleLike(postId) {
    console.log('Liking post:', postId);

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    try {
        // Try the simple route first
        const response = await fetch(`/simple-like/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });

        console.log('Response status:', response.status);

        if (response.ok) {
            const data = await response.json();
            console.log('Success:', data);

            // Update UI
            const likeIcon = document.getElementById(`like-icon-${postId}`);
            const likeText = document.getElementById(`like-text-${postId}`);
            const likeCount = document.getElementById(`like-count-${postId}`);
            const likeButton = document.getElementById(`like-button-${postId}`);

            if (data.is_liked) {
                likeIcon.textContent = '❤️';
                likeText.textContent = 'Liked';
                likeButton.classList.remove('text-blue-600', 'hover:text-blue-800');
                likeButton.classList.add('text-pink-600', 'hover:text-pink-800');
            } else {
                likeIcon.textContent = '🤍';
                likeText.textContent = 'Like';
                likeButton.classList.remove('text-pink-600', 'hover:text-pink-800');
                likeButton.classList.add('text-blue-600', 'hover:text-blue-800');
            }

            likeCount.textContent = `${data.likes_count} Likes`;

            return;
        }

        // If simple route fails, try the original
        console.log('Trying original route...');
        const originalResponse = await fetch(`/posts/${postId}/toggle-like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            credentials: 'include'
        });

        if (originalResponse.ok) {
            const data = await originalResponse.json();
            console.log('Original route success:', data);
            // Update UI...
        } else {
            console.error('Both routes failed');
        }

    } catch (error) {
        console.error('Error:', error);
    }
}
