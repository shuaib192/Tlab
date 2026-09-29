<style>
    .flow-body {
        background-color: #F7FAFA;
    }
    .paper-card {
        background: #FFFFFF;
        border: 1px solid #E3EBEA;
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(11, 31, 28, 0.04);
        transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease;
    }
    .paper-card:hover {
        border-color: #CFE3E0;
        box-shadow: 0 12px 28px -14px rgba(11, 31, 28, 0.22);
    }
    .paper-tag {
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
    .paper-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-weight: 800;
        font-size: .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        padding: .32rem .72rem;
        border-radius: 999px;
    }
    .btn-flat {
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
        transition: background .15s ease, transform .15s ease;
    }
    .btn-flat:hover { background: #0A9184; border-color: #0A9184; }
    .btn-flat:active { transform: translateY(1px); }
    .btn-flat.soft { background: #fff; color: #0F201E; border-color: #DDE4E3; }
    .btn-flat.soft:hover { background: #F1F5F4; border-color: #CFE3E0; }
    .section-kicker {
        font-weight: 900;
        font-size: .7rem;
        letter-spacing: .24em;
        text-transform: uppercase;
        color: #0A7A6E;
    }
    .flow-rail {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: .35rem;
        margin-bottom: 2.75rem;
        overflow-x: auto;
        padding-bottom: .35rem;
    }
    .flow-station {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: .5rem;
        min-width: 54px;
    }
    .flow-dot {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #DDE4E3;
        background: #fff;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: .85rem;
        color: #5B6B69;
        flex-shrink: 0;
    }
    .flow-dot.done { background: #0DAA9C; border-color: #0DAA9C; color: #fff; }
    .flow-dot.current { background: #0F201E; border-color: #0F201E; color: #fff; box-shadow: 0 0 0 5px rgba(13, 170, 156, 0.18); }
    .flow-label {
        font-weight: 800;
        font-size: .62rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #0F201E;
        text-align: center;
        line-height: 1.2;
        white-space: nowrap;
    }
    .flow-label.muted { color: #9AA8A6; }
    .flow-connector {
        flex-shrink: 1;
        width: 100%;
        min-width: 22px;
        max-width: 56px;
        height: 3px;
        border-top: 2px dashed #DDE4E3;
        margin-top: 18px;
    }
    .flow-connector.done { border-color: rgba(13, 170, 156, 0.5); }
    [x-cloak] { display: none !important; }
</style>
