@once
    @push('admin-styles')
        <style>
            body.is-admin #main-content {
                padding-top: calc(var(--navbar-height) + 2rem);
            }

            .crud-toolbar {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
            }

            .crud-actions {
                display: flex;
                gap: .75rem;
                flex-wrap: wrap;
            }

            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1rem;
                margin-bottom: 1.5rem;
            }

            .stat-card {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
            }

            .stat-card-icon {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.35rem;
                background: rgba(113, 161, 224, .14);
                color: #1b3a5c;
            }

            .stat-card-label {
                font-size: .8rem;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: #6a8ea8;
                margin-bottom: .35rem;
            }

            .stat-card-value {
                font-size: 1.8rem;
                font-weight: 700;
                color: #0d2a42;
                line-height: 1;
            }

            .admin-card + .admin-card {
                margin-top: 1.5rem;
            }

            .table thead th {
                font-size: .78rem;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #6a8ea8;
                border-bottom-width: 1px;
            }

            .table td {
                vertical-align: middle;
            }

            .muted {
                color: #6a8ea8;
                font-size: .92rem;
            }

            .form-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1rem;
            }

            .form-grid .full-span {
                grid-column: 1 / -1;
            }

            .detail-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1rem;
            }

            .detail-item {
                padding: 1rem;
                border: 1px solid #d6e4f0;
                border-radius: 12px;
                background: #f9fbfd;
            }

            .detail-label {
                display: block;
                font-size: .78rem;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: #6a8ea8;
                margin-bottom: .35rem;
            }

            .detail-value {
                color: #0d2a42;
                font-weight: 600;
            }

            .thumb-list {
                display: flex;
                flex-wrap: wrap;
                gap: .75rem;
                margin-top: 1rem;
            }

            .thumb-list img {
                width: 84px;
                height: 84px;
                object-fit: cover;
                border-radius: 12px;
                border: 1px solid #d6e4f0;
            }

            .empty-state {
                padding: 2rem;
                text-align: center;
                color: #6a8ea8;
            }

            @media (max-width: 991px) {
                body.is-admin #main-content {
                    padding-top: calc(var(--navbar-height) + 1.5rem);
                    padding-left: 1rem;
                    padding-right: 1rem;
                }
            }
        </style>
    @endpush
@endonce
