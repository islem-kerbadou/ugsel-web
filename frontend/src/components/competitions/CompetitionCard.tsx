import React, { useState } from 'react';
import { Competition } from '../../types';
import { ChampionshipList } from '../championships/ChampionshipList';
import { Button } from '../common/Button';

interface CompetitionCardProps {
  competition: Competition;
  onDelete: (id: number) => void;
}

export const CompetitionCard: React.FC<CompetitionCardProps> = ({
  competition,
  onDelete,
}) => {
  const [expanded, setExpanded] = useState(false);
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);

  const handleDelete = () => {
    if (competition.id) {
      onDelete(competition.id);
      setShowDeleteConfirm(false);
    }
  };

  return (
    <div className="card mb-2">
      <div
        className="card-header bg-light d-flex justify-content-between align-items-center"
        style={{ cursor: 'pointer' }}
        onClick={() => setExpanded(!expanded)}
      >
        <div>
          <h6 className="mb-1">{competition.name}</h6>
          <small className="text-muted">
            {competition.championships?.length || 0} championnat(s)
          </small>
        </div>
        <div className="d-flex gap-2 align-items-center">
          <button
            className="btn btn-sm btn-link text-decoration-none"
            onClick={(e) => {
              e.stopPropagation();
              setExpanded(!expanded);
            }}
          >
            {expanded ? '▼' : '▶'}
          </button>
          <Button
            variant="danger"
            size="sm"
            onClick={(e) => {
              e?.stopPropagation();
              setShowDeleteConfirm(true);
            }}
          >
            Supprimer
          </Button>
        </div>
      </div>

      {showDeleteConfirm && (
        <div className="alert alert-warning m-2 mb-0">
          <p className="mb-2 small">Êtes-vous sûr de vouloir supprimer cette compétition ?</p>
          <div className="d-flex gap-2">
            <Button variant="danger" size="sm" onClick={handleDelete}>
              Confirmer
            </Button>
            <Button variant="secondary" size="sm" onClick={() => setShowDeleteConfirm(false)}>
              Annuler
            </Button>
          </div>
        </div>
      )}

      {expanded && competition.id && (
        <div className="card-body">
          <ChampionshipList competitionId={competition.id} competitionName={competition.name} />
        </div>
      )}
    </div>
  );
};
