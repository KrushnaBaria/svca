<!-- <h1>Dashboard</h1> -->

<style>
@keyframes gradientMove {
    0% {
        background-position: 0% 50%;
    }
    100% {
        background-position: 100% 50%;
    }
}
.animated-title {
    font-size: 2.8em;
    font-weight: 900;
    letter-spacing: 3px;
    text-align: center;
    margin-top: 50px;
    padding: 0.4em 0;
    background: linear-gradient(270deg, #e74c3c, #f1c40f, #2ecc71, #3498db, #9b59b6, #e74c3c);
    background-size: 1200% 1200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientMove 3s linear infinite alternate;
    filter: drop-shadow(0 2px 8px rgba(52,152,219,0.15));
    border-radius: 12px;
    transition: transform 0.2s;
}
.animated-title:hover {
    transform: scale(1.05) rotate(-1deg);
    filter: drop-shadow(0 4px 16px rgba(155,89,182,0.25));
}
</style>
<div class="animated-title">Dashboard Available Soon...</div>