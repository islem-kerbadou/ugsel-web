import React, { useState } from 'react';
import { Input } from '../common/Input';
import { Button } from '../common/Button';
import { ErrorMessage } from '../common/ErrorMessage';

interface SportTypeFormProps {
  onSubmit: (code: string, label: string, types: ('individuel' | 'collectif')[]) => Promise<void>;
  onCancel?: () => void;
  inline?: boolean;
}

export const SportTypeForm: React.FC<SportTypeFormProps> = ({
  onSubmit,
  onCancel,
  inline = false,
}) => {
  const [code, setCode] = useState('');
  const [label, setLabel] = useState('');
  const [selectedTypes, setSelectedTypes] = useState<('individuel' | 'collectif')[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [submitting, setSubmitting] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setError(null);

    if (!code.trim()) {
      setError('Le code est requis');
      return;
    }

    if (selectedTypes.length === 0) {
      setError('Veuillez sélectionner au moins un type (individuel ou collectif)');
      return;
    }

    try {
      setSubmitting(true);
      await onSubmit(code.trim(), label.trim() || code.trim(), selectedTypes);
      setCode('');
      setLabel('');
      setSelectedTypes([]);
      if (inline && onCancel) {
        onCancel();
      }
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Erreur lors de la création du type de sport');
    } finally {
      setSubmitting(false);
    }
  };

  const toggleType = (type: 'individuel' | 'collectif') => {
    setSelectedTypes((prev) =>
      prev.includes(type) ? prev.filter((t) => t !== type) : [...prev, type]
    );
  };

  return (
    <form className={inline ? 'bg-light p-3 rounded border' : 'card shadow-sm'} onSubmit={handleSubmit}>
      {!inline && (
        <div className="card-body">
          <h3 className="card-title mb-4">Créer un type de sport</h3>
        </div>
      )}

      <div className={inline ? '' : 'card-body'}>
        {error && <ErrorMessage message={error} onDismiss={() => setError(null)} />}

        <Input
          label="Code"
          value={code}
          onChange={setCode}
          placeholder="Ex: INDIVIDUEL, COLLECTIF, MIXTE"
          required
          error={error && !code.trim() ? 'Le code est requis' : undefined}
        />

        <Input
          label="Libellé (optionnel)"
          value={label}
          onChange={setLabel}
          placeholder="Ex: Sport individuel, Sport collectif..."
        />

        <div className="mb-3">
          <label className="form-label">Types :</label>
          <div className="d-flex gap-3">
            <div className="form-check">
              <input
                className="form-check-input"
                type="checkbox"
                id="type-individuel"
                checked={selectedTypes.includes('individuel')}
                onChange={() => toggleType('individuel')}
              />
              <label className="form-check-label" htmlFor="type-individuel">
                Individuel
              </label>
            </div>
            <div className="form-check">
              <input
                className="form-check-input"
                type="checkbox"
                id="type-collectif"
                checked={selectedTypes.includes('collectif')}
                onChange={() => toggleType('collectif')}
              />
              <label className="form-check-label" htmlFor="type-collectif">
                Collectif
              </label>
            </div>
          </div>
          {error && selectedTypes.length === 0 && (
            <div className="text-danger small mt-1">Sélectionnez au moins un type</div>
          )}
        </div>

        <div className="d-flex gap-2 justify-content-end">
          <Button type="submit" disabled={submitting}>
            {submitting ? 'Création...' : 'Créer le type'}
          </Button>
          {onCancel && (
            <Button type="button" variant="secondary" onClick={onCancel}>
              Annuler
            </Button>
          )}
        </div>
      </div>
    </form>
  );
};
