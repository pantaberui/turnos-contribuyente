<style>
    .pdf-footer {
        width: 100%;
        font-family: Arial, sans-serif;
        font-size: 7px;
        color: #444;
        padding: 0 20px;
        box-sizing: border-box;
    }

    .pdf-footer-inner {
        border-top: 1px solid #999;
        padding-top: 4px;
        display: flex;
        justify-content: space-between;
    }
</style>

<div class="pdf-footer">
    <div class="pdf-footer-inner">
        <div>
            Generado: {{ now()->format('d/m/Y H:i') }}
        </div>

        <div>
            Página <span class="pageNumber"></span> de <span class="totalPages"></span>
        </div>
    </div>
</div>