import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

export default function AccountTransactions() {
    const { account, transactions } = usePage().props;

    return (
        <div>
            <h1>Transactions for {account.name}</h1>
            <ul>
                {transactions.data.map(transaction => (
                    <li key={transaction.id}>{transaction.description}: ${transaction.amount}</li>
                ))}
            </ul>
            {/* Add pagination links here if needed */}
        </div>
    );
}
