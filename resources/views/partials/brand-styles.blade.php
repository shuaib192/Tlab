<style>
    .brand-page { background-color: #F7FAFA; color: #0F201E; }
    .brand-card {
        background: #FFFFFF;
        border: 1px solid #E3EBEA;
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(11, 31, 28, .04);
        transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease;
    }
    .brand-card:hover {
        border-color: #CFE3E0;
        box-shadow: 0 12px 28px -14px rgba(11, 31, 28, .22);
    }
    .brand-kicker {
        font-weight: 900;
        font-size: .7rem;
        letter-spacing: .24em;
        text-transform: uppercase;
        color: #0A7A6E;
    }
    .brand-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: #0DAA9C;
        color: #fff;
        font-weight: 800;
        font-size: .66rem;
        letter-spacing: .14em;
        text-transform: uppercase;
        padding: .42rem .85rem;
        border-radius: 999px;
    }
    .brand-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-weight: 800;
        font-size: .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: .32rem .72rem;
        border-radius: 999px;
        background: rgba(13, 170, 156, .1);
        color: #0A7A6E;
    }
    .brand-pill {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-weight: 800;
        font-size: .68rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: .4rem .8rem;
        border-radius: 999px;
        border: 1px solid #DDE4E3;
        background: #fff;
        color: #5B6B69;
    }
    .brand-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        background: #0DAA9C;
        color: #fff;
        font-weight: 800;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        padding: .9rem 1.5rem;
        border-radius: 12px;
        border: 1px solid #0DAA9C;
        transition: background .15s ease, transform .15s ease, border-color .15s ease;
    }
    .brand-btn:hover { background: #0A9184; border-color: #0A9184; }
    .brand-btn:active { transform: translateY(1px); }
    .brand-btn.soft { background: #fff; color: #0F201E; border-color: #DDE4E3; }
    .brand-btn.soft:hover { background: #F1F5F4; border-color: #CFE3E0; }
    .brand-title {
        font-weight: 900;
        letter-spacing: -.02em;
        color: #0F201E;
        line-height: 1.05;
    }
    .brand-node {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #DDE4E3;
        background: #fff;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: .85rem;
        color: #0F201E;
        flex-shrink: 0;
    }
    .brand-node.on { background: #0DAA9C; border-color: #0DAA9C; color: #fff; }
</style>
