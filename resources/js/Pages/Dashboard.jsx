import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

export default function Dashboard() {
    const { user, accounts, recent_transactions, total_balance } = usePage().props;

    return (
        <div>
            <h1>Welcome, {user.name}</h1>
            <h2>Total Balance: ${total_balance}</h2>
            <h3>Accounts:</h3>
            <ul>
                {accounts.map(account => (
                    <li key={account.id}>{account.name}: ${account.balance}</li>
                ))}
            </ul>
            <h3>Recent Transactions:</h3>
            <ul>
                {recent_transactions.map(transaction => (
                    <li key={transaction.id}>{transaction.description}: ${transaction.amount}</li>
                ))}
            </ul>
        </div>
    );
}
