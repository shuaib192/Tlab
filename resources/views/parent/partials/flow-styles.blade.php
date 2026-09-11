<style>
    .flow-body {
        background-color: #F6F2E9;
        background-image: radial-gradient(rgba(27, 27, 30, 0.09) 1px, transparent 1px);
        background-size: 22px 22px;
    }
    .paper-card {
        background: #FFFFFF;
        border: 2px solid #1B1B1E;
        border-radius: 18px;
        box-shadow: 7px 7px 0 rgba(27, 27, 30, 0.14);
    }
    .paper-tag {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: #1B1B1E;
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
        background: #1B1B1E;
        color: #fff;
        font-weight: 800;
        font-size: .85rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        padding: .9rem 1.5rem;
        border-radius: 13px;
        border: 2px solid #1B1B1E;
        box-shadow: 5px 5px 0 rgba(27, 27, 30, 0.18);
        transition: transform .12s ease, box-shadow .12s ease;
    }
    .btn-flat:hover { transform: translate(-1px, -1px); box-shadow: 7px 7px 0 rgba(27, 27, 30, 0.18); }
    .btn-flat:active { transform: translate(4px, 4px); box-shadow: 0 0 0 transparent; }
    .btn-flat.soft { background: #fff; color: #1B1B1E; box-shadow: 5px 5px 0 rgba(27, 27, 30, 0.13); }
    .btn-flat.soft:hover { box-shadow: 7px 7px 0 rgba(27, 27, 30, 0.13); }
    .section-kicker {
        font-weight: 900;
        font-size: .7rem;
        letter-spacing: .24em;
        text-transform: uppercase;
        color: #16A34A;
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
        border: 3px solid #1B1B1E;
        background: #fff;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: .85rem;
        color: #1B1B1E;
        flex-shrink: 0;
    }
    .flow-dot.done { background: #16A34A; color: #fff; }
    .flow-dot.current { background: #1B1B1E; color: #fff; box-shadow: 0 0 0 6px rgba(22, 163, 74, 0.18); }
    .flow-label {
        font-weight: 800;
        font-size: .62rem;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #1B1B1E;
        text-align: center;
        line-height: 1.2;
        white-space: nowrap;
    }
    .flow-label.muted { color: #9A9282; }
    .flow-connector {
        flex-shrink: 1;
        width: 100%;
        min-width: 22px;
        max-width: 56px;
        height: 3px;
        border-top: 3px dashed rgba(27, 27, 30, 0.35);
        margin-top: 18px;
    }
    .flow-connector.done { border-color: rgba(22, 163, 74, 0.5); }
    [x-cloak] { display: none !important; }
</style>