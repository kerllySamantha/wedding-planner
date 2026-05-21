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

            .dashboard-header {
                margin-bottom: 2rem;
            }

            .dashboard-header h1 {
                margin-bottom: .55rem;
            }

            .dashboard-header p {
                font-size: 1.08rem;
                max-width: 72ch;
            }

            .dashboard-stats {
                gap: 1.35rem;
                margin-bottom: 1.9rem;
            }

            .stat-card {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                min-height: 142px;
                padding: 1.5rem 1.6rem;
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
                font-size: 2rem;
                font-weight: 700;
                color: #0d2a42;
                line-height: 1;
            }

            .dashboard-quick-actions {
                padding: 1.9rem 2rem;
                margin-bottom: 1.9rem;
            }

            .dashboard-toolbar {
                align-items: center;
                gap: 1.5rem;
            }

            .dashboard-actions {
                gap: 1rem;
            }

            .dashboard-actions .btn {
                min-height: 48px;
                padding-inline: 1.35rem;
                border-radius: 12px;
                font-weight: 600;
            }

            .dashboard-tables .admin-card {
                padding: 1.9rem 2rem;
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
                align-items: start;
            }

            .form-grid .full-span {
                grid-column: 1 / -1;
            }

            .form-grid > div {
                display: flex;
                flex-direction: column;
                gap: .45rem;
            }

            .form-label {
                margin-bottom: 0;
                font-weight: 600;
                color: #1b3a5c;
            }

            .crud-toolbar .page-header p {
                margin-bottom: 0;
            }

            .admin-card form .d-flex.justify-content-end {
                margin-top: .5rem;
                padding-top: 1rem;
                border-top: 1px solid #d6e4f0;
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
