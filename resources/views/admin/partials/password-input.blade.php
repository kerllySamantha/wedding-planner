{{--
    Variables esperadas (via @include):
      $pwId       - id y name del input ('password' | 'password_confirmation')
      $pwLabel    - texto del label
      $pwRequired - bool
      $pwHint     - (opcional) texto de ayuda
--}}
<div>
    <label for="{{ $pwId }}" class="form-label fw-semibold">
        <i class="bi bi-lock text-muted me-1" style="font-size:.85em"></i>{{ $pwLabel }}
    </label>

    <div class="pw-field">
        <input
            type="password"
            id="{{ $pwId }}"
            name="{{ $pwId }}"
            class="form-control @error($pwId) is-invalid @enderror"
            autocomplete="new-password"
            {{ ($pwRequired ?? false) ? 'required' : '' }}>

        <button type="button"
            class="pw-field__toggle toggle-pw-btn"
            data-target="{{ $pwId }}"
            tabindex="-1"
            aria-label="Ver u ocultar contraseña">
            <i class="bi bi-eye-slash" id="eye-{{ $pwId }}"></i>
        </button>

        @error($pwId)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    @if (!empty($pwHint))
        <small class="text-muted d-block mt-1" style="font-size:.78rem">
            <i class="bi bi-info-circle me-1"></i>{{ $pwHint }}
        </small>
    @endif

    @if (($pwId ?? '') === 'password')
        <div class="password-strength mt-2" id="pw-strength-box" style="display:none">
            <div class="d-flex align-items-center gap-2 mb-1">
                <div class="flex-grow-1" style="height:5px;border-radius:3px;background:var(--admin-border);overflow:hidden">
                    <div id="pw-strength-bar"
                        style="height:100%;width:0%;border-radius:3px;transition:width .25s ease,background-color .25s ease"></div>
                </div>
                <small id="pw-strength-label" style="font-size:.73rem;font-weight:600;white-space:nowrap;min-width:5rem;text-align:right"></small>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-1">
                <span class="req-item" data-req="length">
                    <i class="bi bi-x-circle-fill text-danger" id="req-length"></i> 8 caracteres
                </span>
                <span class="req-item" data-req="upper">
                    <i class="bi bi-x-circle-fill text-danger" id="req-upper"></i> Mayúscula
                </span>
                <span class="req-item" data-req="number">
                    <i class="bi bi-x-circle-fill text-danger" id="req-number"></i> Número
                </span>
                <span class="req-item" data-req="symbol">
                    <i class="bi bi-x-circle-fill text-danger" id="req-symbol"></i> Símbolo
                </span>
            </div>
        </div>
    @endif
</div>

@pushOnce('admin-scripts')
<script>
(function () {
    /* ── Toggle mostrar / ocultar ── */
    document.querySelectorAll('.toggle-pw-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = document.getElementById(this.dataset.target);
            var icon  = document.getElementById('eye-' + this.dataset.target);
            if (!input) return;
            var show = input.type === 'password';
            input.type      = show ? 'text'     : 'password';
            icon.className  = show ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    });

    /* ── Medidor de fortaleza ── */
    var pwInput     = document.getElementById('password');
    var strengthBox = document.getElementById('pw-strength-box');
    var strengthBar = document.getElementById('pw-strength-bar');
    var strengthLbl = document.getElementById('pw-strength-label');

    if (!pwInput || !strengthBox) return;

    var levels = [
        { pct: 12,  color: '#dc3545', text: 'Muy débil'  },
        { pct: 38,  color: '#fd7e14', text: 'Débil'       },
        { pct: 62,  color: '#ffc107', text: 'Media'       },
        { pct: 86,  color: '#198754', text: 'Fuerte'      },
        { pct: 100, color: '#0f6848', text: 'Muy fuerte'  },
    ];

    function setReq(id, ok) {
        var el = document.getElementById('req-' + id);
        if (!el) return;
        el.className = ok
            ? 'bi bi-check-circle-fill'
            : 'bi bi-x-circle-fill text-danger';
        el.style.color = ok ? 'var(--admin-primary)' : '';
    }

    pwInput.addEventListener('input', function () {
        var v = this.value;
        if (!v) { strengthBox.style.display = 'none'; return; }
        strengthBox.style.display = 'block';

        var ok = {
            length : v.length >= 8,
            upper  : /[A-Z]/.test(v),
            number : /[0-9]/.test(v),
            symbol : /[^A-Za-z0-9]/.test(v),
        };
        setReq('length', ok.length);
        setReq('upper',  ok.upper);
        setReq('number', ok.number);
        setReq('symbol', ok.symbol);

        var score = Object.values(ok).filter(Boolean).length;
        var lvl   = levels[score] || levels[levels.length - 1];
        strengthBar.style.width           = lvl.pct + '%';
        strengthBar.style.backgroundColor = lvl.color;
        strengthLbl.textContent           = lvl.text;
        strengthLbl.style.color           = lvl.color;
    });
}());
</script>
@endPushOnce
